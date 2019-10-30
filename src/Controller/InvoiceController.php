<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\DesdeHastaFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    /**
     * @Route("/invoices", name="invoices")
     * @throws \Exception
     */
    public function indexAction(EntityManagerInterface $em, Request $request)
    {
        $repository = $em->getRepository(Invoice::class);
        $invoices = $repository->findAll();

        $form = $this->createForm(DesdeHastaFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            dd($data);
            if ($data['desde']>(new \DateTime('today'))) {
                throw new \Exception('Pick a valid date');
            }
            $invoices = $repository->findAllBetweenDates($data['desde'], $data['hasta']);
            return $this->render('invoice/invoices.html.twig', [
                'invoices' => $invoices,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('invoice/invoices.html.twig', [
            'invoices' => $invoices,
            'form' => $form->createView(),
        ]);
    }
}
