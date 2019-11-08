<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\DesdeHastaFormType;
use App\Form\InvoiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    /**
     * @Route("/invoices", name="invoices")
     */
    public function indexAction(EntityManagerInterface $em, Request $request)
    {
        $repository = $em->getRepository(Invoice::class);
        $invoices = $repository->findAllOrderedByNewest();

        $form = $this->createForm(DesdeHastaFormType::class);

        if ($request->isMethod('post')){
            $datefilter = $request->request->get('datefilter');
            $dates = explode(" ", $datefilter);

            $invoices = $repository->findAllBetweenDates(new \DateTime($dates[0]), new \DateTime($dates[2]));
            return $this->render('invoice/invoices.html.twig', [
                'invoices' => $invoices,
                'form' => $form->createView(),
                'datefilter' => $datefilter,
            ]);
        }

        $datefilter = "";

        return $this->render('invoice/invoices.html.twig', [
            'invoices' => $invoices,
            'form' => $form->createView(),
            'datefilter' => $datefilter,
        ]);
    }

    /**
     * @Route("/invoices/new", name="invoices_new")
     */
    public function createAction(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(InvoiceType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $invoice = $form->getData();
            $invoice->setInvoicedAt($form['formdate']->getData());
            $em->persist($invoice);
            $em->flush();
            $this->addFlash('success', 'Invoice Created!');
            return $this->redirectToRoute('invoices');
        }

        return $this->render('invoice/new.html.twig', [
            'invoiceForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/invoices/{id}/edit", name="invoices_edit")
     */
    public function updateAction(Invoice $invoice, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $invoice = $form->getData();
            $invoice->setInvoicedAt($form['formdate']->getData());
            $em->persist($invoice);
            $em->flush();
            $this->addFlash('success', 'Invoice Updated!');
            return $this->redirectToRoute('invoices');
        }

        return $this->render('invoice/edit.html.twig', [
            'invoiceForm' => $form->createView(),
            'invoicedAt' => $invoice->getStringInvoicedAt(),
        ]);
    }

    /**
     * @Route("/invoices/{id}/remove", name="invoices_remove")
     */
    public function remove(Invoice $invoice, EntityManagerInterface $em)
    {
        $em->remove($invoice);
        $em->flush();

        return $this->redirectToRoute('invoices');
    }

}