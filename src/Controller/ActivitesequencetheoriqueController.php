<?php

namespace App\Controller;

use App\Entity\Activitesequencetheorique;
use App\Form\ActivitesequencetheoriqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activitesequencetheorique")
 */
class ActivitesequencetheoriqueController extends AbstractController
{
    /**
     * @Route("/", name="activitesequencetheorique_index", methods={"GET"})
     */
    public function index(): Response
    {
        $activitesequencetheoriques = $this->getDoctrine()
            ->getRepository(Activitesequencetheorique::class)
            ->findAll();

        return $this->render('activitesequencetheorique/index.html.twig', [
            'activitesequencetheoriques' => $activitesequencetheoriques,
        ]);
    }

    /**
     * @Route("/new", name="activitesequencetheorique_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $activitesequencetheorique = new Activitesequencetheorique();
        $form = $this->createForm(ActivitesequencetheoriqueType::class, $activitesequencetheorique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activitesequencetheorique);
            $entityManager->flush();

            return $this->redirectToRoute('activitesequencetheorique_index');
        }

        return $this->render('activitesequencetheorique/new.html.twig', [
            'activitesequencetheorique' => $activitesequencetheorique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activitesequencetheorique_show", methods={"GET"})
     */
    public function show(Activitesequencetheorique $activitesequencetheorique): Response
    {
        return $this->render('activitesequencetheorique/show.html.twig', [
            'activitesequencetheorique' => $activitesequencetheorique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activitesequencetheorique_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activitesequencetheorique $activitesequencetheorique): Response
    {
        $form = $this->createForm(ActivitesequencetheoriqueType::class, $activitesequencetheorique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activitesequencetheorique_index');
        }

        return $this->render('activitesequencetheorique/edit.html.twig', [
            'activitesequencetheorique' => $activitesequencetheorique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activitesequencetheorique_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Activitesequencetheorique $activitesequencetheorique): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activitesequencetheorique->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activitesequencetheorique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activitesequencetheorique_index');
    }
}
