<?php

namespace App\Controller;

use App\Services\ImageParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    #[Route('/gallery/{slug}', name: 'app_gallery', methods: 'GET')]
    public function index(string $slug, ImageParser $imageParser): Response
    {
        $parsedData = $imageParser->execute(base64_decode($slug));

        return $this->render('gallery/index.html.twig', [
            'galleryData' => $parsedData,
        ]);
    }
}
