<?php

namespace App\Controller;

use App\Entity\Activitesequencetheorique;
use App\Entity\Atelier;
use App\Entity\Sequencetheorique;
use App\Form\ActivitesequencetheoriqueType;
use App\Form\SequencetheoriqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/donneInfoAtelier/", name="donneInfoAtelier_ajax", methods={"GET"})
     */
    public function donneInfoAtelier_ajax(Request $request): Response
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();


        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $ateliers =  $em->getRepository(Atelier::class)
            ->createQueryBuilder("a")
            ->where("a.id = :idAtelier")
            ->setParameter("idAtelier", $request->query->get("atelierid"))
            ->getQuery()
            ->getResult();



        $responseArray = array(
                "unitedeperformance" => $ateliers[0]->getUnitedeperformance(),
                "unitedintensite" => $ateliers[0]->getUnitedintensite(),
            );



        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);
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
     * @Route("/{id}", name="sequencetheorique_show", methods={"GET","POST"})
     */
    public function show(Sequencetheorique $sequencetheorique, Request $request): Response
    {
        $activitesequencetheorique = new Activitesequencetheorique();
        $form = $this->createForm(ActivitesequencetheoriqueType::class, $activitesequencetheorique);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $activitesequencetheoriques = $this->getDoctrine()
                ->getRepository(Activitesequencetheorique::class)
                ->findBy(['idsequencetheorique' => $sequencetheorique->getId()]);
            $activitesequencetheorique->setOrdre(count($activitesequencetheoriques));
            $activitesequencetheorique->setIdsequencetheorique($sequencetheorique);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activitesequencetheorique);
            $entityManager->flush();

            $activitesequencetheorique = new Activitesequencetheorique();
            $form = $this->createForm(ActivitesequencetheoriqueType::class, $activitesequencetheorique);
            $form->handleRequest($request);

         //   return $this->redirectToRoute('activitesequencetheorique_index');
        }
        else{
            $activitesequencetheoriques = $this->getDoctrine()
                ->getRepository(Activitesequencetheorique::class)
                ->findBy(['idsequencetheorique' => $sequencetheorique->getId()]);
            $ateliers=$this->getDoctrine()
                ->getRepository(Atelier::class)
                ->findAll();
            $atelier = $ateliers[0];

        }



        return $this->render('sequencetheorique/show.html.twig', [
            'sequencetheorique' => $sequencetheorique,
            'activitesequencetheoriques' => $activitesequencetheoriques,
            'form' => $form->createView(),
            'atelier' => $atelier
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
