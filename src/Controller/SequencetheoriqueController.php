<?php

namespace App\Controller;

use App\Entity\Sequencetheorique;
use App\Form\SequencetheoriqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sequencetheorique")
 */
class SequencetheoriqueController extends AbstractController
{
    /**
     * @Route("/", name="sequencetheorique_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sequencetheoriques = $this->getDoctrine()
            ->getRepository(Sequencetheorique::class)
            ->findAll();

        return $this->render('sequencetheorique/index.html.twig', [
            'sequencetheoriques' => $sequencetheoriques,
        ]);
    }

    /**
     * @Route("/new", name="sequencetheorique_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sequencetheorique = new Sequencetheorique();
        $form = $this->createForm(SequencetheoriqueType::class, $sequencetheorique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sequencetheorique);
            $entityManager->flush();

            return $this->redirectToRoute('sequencetheorique_index');
        }

        return $this->render('sequencetheorique/new.html.twig', [
            'sequencetheorique' => $sequencetheorique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sequencetheorique_show", methods={"GET"})
     */
    public function show(Sequencetheorique $sequencetheorique): Response
    {
        return $this->render('sequencetheorique/show.html.twig', [
            'sequencetheorique' => $sequencetheorique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sequencetheorique_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sequencetheorique $sequencetheorique): Response
    {
        $form = $this->createForm(SequencetheoriqueType::class, $sequencetheorique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sequencetheorique_index');
        }

        return $this->render('sequencetheorique/edit.html.twig', [
            'sequencetheorique' => $sequencetheorique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sequencetheorique_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sequencetheorique $sequencetheorique): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sequencetheorique->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sequencetheorique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sequencetheorique_index');
    }
}
