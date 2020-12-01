<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET"}))
     */
    public function index(PinRepository $repo): Response
    {
        $pins= $repo->findAll();
        return $this->render('pins/index.html.twig', compact('pins'));
    }

    /**
     * @Route("/pins/{id}", methods={"GET"}))
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }
}
