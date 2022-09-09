<?php

namespace App\Controller;

use App\Entity\Report;
use App\Entity\ReportLog;
use App\Form\ReportType;
use App\Repository\ReportLogRepository;
use App\Repository\ReportRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/report')]
class ReportController extends AbstractController
{
    #[Route('/', name: 'app_report', methods: ['GET'])]
    public function index(ReportRepository $reportRepository): Response
    {
        return $this->render('report/report.html.twig', [
            'reports' => $reportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_report_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReportRepository $reportRepository, ReportLogRepository $reportLogRepository): Response
    {
        if (isset($_POST["g-recaptcha-response"])) {
            $spam = 0;
            $captcha = $_POST["g-recaptcha-response"];
            if (!$captcha) {
                // It's a Bot do something about it;
                $spam = -1;
            } else {
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdfZ-EhAAAAALmT7Lap2W3SzsfVqNwCSjgHzIz_&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
                $response = json_decode($response);
                if ($response->success === false) {
                    // It's a Bot do something about it
                    $spam = -1;
                }
                if ($response->success && $response->score <= 0.5) {
                    // It's probably a Bot, do somethiongs about it.;
                    $spam = -1;
                }
                if (!$spam) {
                    // Send your mail form or whatever you want to do, it wasn't a Bot.
                    print "You are human, hello, nice to meet you!.";
                } else {
                    // It's a bot, don't do anything, better still make it look as though you have done something ;).
                    print "You are human, hello!.";  // But in fact I know you're a bot, go away!
                }
            }
        }

        $reportLog = new ReportLog();

        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        $report->setReportDate(new DateTimeImmutable());
        $report->setUserAgent($request->headers->get('User-Agent'));

        if ($form->isSubmitted()) {
            if ($report->getPhoneNumber() == '' && $report->getEmail() == '' && $request->request->get('checkbox')) {
                $form->addError(new FormError("You agreed for notfications, so you need to add valid phone number or email"));
            } else {
                $report->setPhoneNumber('');
                $report->setEmail('');
            }
            if ($form->isValid()) {
                $reportLog->setSeen(0);
                $reportLog->setState("new");
                $reportLogRepository->add($reportLog, true);
                $report->setReportLog($reportLog);
                $reportRepository->add($report, true);

                return $this->redirectToRoute('app_home_page', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('report/new.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_report_show', methods: ['GET'])]
    public function show(Report $report, ReportLog $reportLog, ReportLogRepository $reportLogRepository): Response
    {

        if ($reportLog->isSeen() == 0) {

            $reportLog->setSeen('1');
            $reportLog->setReadDate(new DateTimeImmutable());
            $reportLog->setFirstWhoRead($this->getUser()->getUserIdentifier());
            $reportLog->setState('in progress');
            $reportLogRepository->add($reportLog, true);
        }
        return $this->render('report/show.html.twig', [
            'report' => $report,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_report_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Report $report, ReportLog $reportLog, ReportRepository $reportRepository): Response
    {
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reportLog->setState($request->request->get('state'));
            $reportRepository->add($report, true);
            return $this->redirectToRoute('app_report', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report/edit.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_report_delete', methods: ['POST'])]
    public function delete(Request $request, Report $report, ReportRepository $reportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $report->getId(), $request->request->get('_token'))) {
            $reportRepository->remove($report, true);
        }

        return $this->redirectToRoute('app_report', [], Response::HTTP_SEE_OTHER);
    }

}