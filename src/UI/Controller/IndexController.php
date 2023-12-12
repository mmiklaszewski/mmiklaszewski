<?php

namespace App\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function index()
    {
        return $this->render('about_me/index.html.twig');
    }

}