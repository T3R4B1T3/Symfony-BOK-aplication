<?php

namespace App\Controller;

use App\Entity\Report;
use App\Entity\ReportLog;
use App\Form\ReportLogType;
use App\Form\ReportType;
use App\Repository\ReportLogRepository;
use App\Repository\ReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\VarDumper\Cloner\Data;

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
    public function new(Request $request, ReportRepository $reportRepository,ReportLogRepository $reportLogRepository): Response
    {
        $reportLog = new ReportLog();


        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        $report->setReportDate(new \DateTimeImmutable());
        $report->setUserAgent($request->headers->get('User-Agent'));



        if ($form->isSubmitted() && $form->isValid()) {
            $reportLog->setSeen(0);
            $reportLog->setState("new");
            $reportLogRepository->add($reportLog,true);
            $report->setReportLog($reportLog);
            $reportRepository->add($report, true);

            return $this->redirectToRoute('app_home_page', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report/new.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_report_show', methods: ['GET'])]
    public function show(Report $report, ReportLog $reportLog, ReportLogRepository $reportLogRepository, $id): Response
    {

        if ($reportLog->isSeen() == 0) {

            $reportLog->setSeen('1');
            $reportLog->setReadDate(new \DateTimeImmutable());
            $reportLog->setFirstWhoRead($this->getUser()->getUserIdentifier());
            $reportLog->setState('In Progers');
            $reportLogRepository->add($reportLog, true);
        }
        return $this->render('report/show.html.twig', [
            'report' => $report,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_report_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Report $report, ReportRepository $reportRepository): Response
    {
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        if ($this->isCsrfTokenValid('delete'.$report->getId(), $request->request->get('_token'))) {
            $reportRepository->remove($report, true);
        }

        return $this->redirectToRoute('app_report', [], Response::HTTP_SEE_OTHER);
    }

}
