<?php

namespace App\Controller;

use App\Entity\Movement;
use App\Form\DesdeHastaFormType;
use App\Form\MovementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovementController extends AbstractController
{
    /**
     * @Route("/movements", name="movements")
     */
    public function indexAction(EntityManagerInterface $em, Request $request)
    {
        $repository = $em->getRepository(Movement::class);
        $movements = $repository->findAllOrderedByNewest();

        $form = $this->createForm(DesdeHastaFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $movements = $repository->findAllBetweenDates($data['desde'], $data['hasta']);
            return $this->render('movement/movements.html.twig', [
                'movements' => $movements,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('movement/movements.html.twig', [
            'movements' => $movements,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/movements/new", name="movements_new")
     */
    public function createAction(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(MovementType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //dd($form->getData());
            $movement = $form->getData();
            $em->persist($movement);
            $em->flush();
            $this->addFlash('success', 'Movement Created!');
            return $this->redirectToRoute('movements');
        }

        return $this->render('movement/new.html.twig', [
            'movementForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/movements/{id}/edit", name="movements_edit")
     */
    public function updateAction(Movement $movement, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //dd($form->getData());
            $movement = $form->getData();
            $em->persist($movement);
            $em->flush();
            $this->addFlash('success', 'Movement Edited!');
            return $this->redirectToRoute('movements');
        }

        return $this->render('movement/edit.html.twig', [
            'movementForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/movements/{id}/remove", name="movements_remove")
     */
    public function removeAction(Movement $movement, EntityManagerInterface $em)
    {
        $em->remove($movement);
        $em->flush();

        return $this->redirectToRoute('movements');
    }

}
