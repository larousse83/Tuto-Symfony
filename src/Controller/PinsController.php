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
        $pins= $repo->findBy([], ['createdAt' => 'DESC']);
        return $this->render('pins/index.html.twig', compact('pins'));
    }

    /**
     * @Route("/pins/create", name="app_pin_create", priority=10, methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin();

        $form = $this->createFormBuilder($pin)
            ->add('title', null, [
                //'required' => false,
                'attr' =>['autofocus' => true]
            ])
            ->add('description', null,['attr' =>[
                'rows' => 10,
                'cols' => 50
            ]])
            ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_pins_show', ['id' => $pin->getId()]);
        }

        return $this->render('pins/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/pins/{id}", methods={"GET"}))
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }

    /**
     * @Route("/pins/{id}/edit", name="app_pins_edit", methods={"GET", "POST"}))
     */
    public function edit(Request $request, EntityManagerInterface $em, Pin $pin): Response
    {
        $form = $this->createFormBuilder($pin)
            ->add('title', null, [
                //'required' => false,
                'attr' =>['autofocus' => true]
            ])
            ->add('description', null,['attr' =>[
                'rows' => 10,
                'cols' => 50
            ]])
            ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/edit.html.twig', [
            'pin' => $pin,
            'form' => $form->createView()
        ]);
    }
}
