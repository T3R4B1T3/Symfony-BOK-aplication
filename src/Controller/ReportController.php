<?php

namespace App\Controller;

use App\Entity\Report;
use App\Entity\ReportLog;
use App\Entity\Comment;
use App\Form\ReportType;
use App\Form\CommentType;
use App\Repository\ReportLogRepository;
use App\Repository\ReportRepository;
use App\Repository\StateRepository;
use App\Repository\CommentRepository;
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
    public function new(Request $request, ReportRepository $reportRepository, ReportLogRepository $reportLogRepository, StateRepository $stateRepository): Response
    {
        $reportLog = new ReportLog();

        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        $report->setReportDate(new DateTimeImmutable());
        $report->setUserAgent($request->headers->get('User-Agent'));

        if ($form->isSubmitted()) {
            if ($report->getPhoneNumber() == '' && $report->getEmail() == '' && $request->request->get('checkbox')) {
                $form->addError(new FormError("You agreed for notifications, so you need to add valid phone number or email"));
            }
            if ($form->isValid()) {
                $reportLog->setSeen(0);
                $reportLog->setState($stateRepository->findOneBy(["name" => "New"]));
                if ($request->request->get('checkbox')) {
                    $report->setUserAgreement(true);
                } else {
                    $report->setUserAgreement(false);
                }
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
    public function show(Request $request, Report $report, ReportLog $reportLog, ReportLogRepository $reportLogRepository, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $comments = $commentRepository->findBy(['reportLog' => $reportLog]);

        if ($reportLog->isSeen() == 0) {
            $reportLog->setSeen('1');
            $reportLog->setReadDate(new DateTimeImmutable());
            $reportLog->setFirstWhoRead($this->getUser()->getUserIdentifier());
            $reportLogRepository->add($reportLog, true);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUsername($this->getUser()->getUserIdentifier());
            $comment->setReportLog($reportLog);
            $comment->setDate(new DateTimeImmutable());
            $commentRepository->add($comment, true);

            return $this->redirectToRoute('app_report_show', ["id" => $request->attributes->get('id')]);
        }

        return $this->renderForm('report/show.html.twig', [
            'report' => $report,
            'form' => $form,
            'comments' => $comments,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_report_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Report $report, ReportLog $reportLog, ReportRepository $reportRepository, StateRepository $stateRepository): Response
    {
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        $states = $stateRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $reportLog->setState($stateRepository->findOneBy(["name" => $request->request->get("state")]));
            $reportRepository->add($report, true);
            return $this->redirectToRoute('app_report', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report/edit.html.twig', [
            'report' => $report,
            'form' => $form,
            'states' => $states,
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