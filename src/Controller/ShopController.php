<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop',methods: ['GET'])]
    public function index(ShopRepository $shopRepository): Response
    {
        return $this->render('shop/index.html.twig', [
            'shops' => $shopRepository->findAll(),
        ]);
    }
    #[Route('/shop/new', name: 'app_shop_new', methods: ['GET','POST'])]
    public function show(ShopRepository $shopRepository,Request $request): Response
    {
        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $shopRepository->add($shop,true);
            return $this->redirectToRoute('app_shop', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('shop/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/shop/{id}/edit', name: 'app_shop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,ShopRepository $shopRepository,Shop $shop): Response
    {

        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shopRepository->add($shop, true);
            return $this->redirectToRoute('app_shop', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shop/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shop_delete', methods: ['POST'])]
    public function delete(Request $request, Shop $shop, ShopRepository $shopRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $shop->getId(), $request->request->get('_token'))) {
            $shopRepository->remove($shop, true);
        }

        return $this->redirectToRoute('app_shop', [], Response::HTTP_SEE_OTHER);
    }
}
