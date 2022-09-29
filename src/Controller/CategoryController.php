<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            return $this->redirectToRoute('app_category', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/category/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            return $this->redirectToRoute('app_category', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/cat/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $reportsPerCategory = $categoryRepository->findAllReportsPerCategory($category->getName());
            if (!empty($reportsPerCategory)) {
                $this->addFlash('notice', "You need to remove all reports with this category first.");
                for ($i = 0; $i < count($reportsPerCategory); $i++) {
                    $this->addFlash('notice', substr($reportsPerCategory[$i]["description"], 0, 40) . "...   ".$reportsPerCategory[$i]["report_date"]);
                }

                return $this->redirectToRoute('app_category');
            } else {
                $categoryRepository->remove($category, true);
            }
        }

        return $this->redirectToRoute('app_category', [], Response::HTTP_SEE_OTHER);
    }


}
