<?php

namespace App\Controller;

use App\Form\SearchImagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/', name: 'app_search')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchImagesType::class, null, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);

        $search = $form->get('search')->getData();

        if ($search && $form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_gallery', ['slug' => base64_encode($search)]);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
