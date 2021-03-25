<?php
namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\CommentaireAtelier;
use App\Entity\Utilisateur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class ControllerUserAct  extends AbstractController
{

    /**
     * @Route(
     *     name="getCurrentUser",
     *     path="/getCurrentUser",
     *     methods={"GET"})
     */
    public function getCurrentUser( ): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $user->eraseCredentials(); //Pour effacer les informations sensibles
        return $this->json($user);
    }

    /**
     * @Route("/api/commentaire/atelier/{id}", name="ajouterCommentaire_route", methods={"POST"})
     *
     * @param Atelier $atelier
     *
     * @return Response
     */
    public function ajouterCommentaire_route(Atelier $atelier, Request $request): Response
    {
        //dd($request);
        $data = $request->toArray();
        //dd($data);
        $commentaire = new CommentaireAtelier();

        $commentaire->setAtelier($atelier);
        $commentaire->setProprietaire($this->getUser());
        $commentaire->setDate(new \DateTime());
        $commentaire->setTitre($data["titre"]);
        $commentaire->setMessage($data["message"]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commentaire);
        $entityManager->flush();
        return $this->json($commentaire);
    }

}