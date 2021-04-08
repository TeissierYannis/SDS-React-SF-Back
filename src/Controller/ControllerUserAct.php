<?php
namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Categoriesequence;
use App\Entity\CommentaireAtelier;
use App\Entity\Utilisateur;
use App\Entity\Sequencetheorique;

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
        return $this->json($user,200,[],['groups'=>'utilisateur:lecture']);
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
        return $this->json($commentaire,200,[],['groups'=>'atelier:lecture']);
    }

    /**
     * @Route("/ajouterSequencetheorique/", name="ajouterSequencetheorique_route", methods={"POST"})
     *
     * @param Atelier $atelier
     *
     * @return Response
     */
    public function ajouterSequencetheorique_route(Atelier $atelier, Request $request): Response
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
        return $this->json($commentaire,200,[],['groups'=>'atelier:lecture']);
    }

    /**
     * @Route("/listesequencespersonnelles/", name="listeSequencesPersonnelles", methods={"GET"})
     *
     *
     * @return Response
     */
    public function listeSequencesPersonnelles(Request $request):Response
    {
        $results = $this
            ->getDoctrine()
            ->getRepository(Sequencetheorique::class)
            ->findBy(['proprietaire'=>$this->getUser()] );
        return $this->json($results,200,[],['groups'=>'sequence:lecture']);
    }

    /**
     * @Route("/creerunesequence/", name="creerunesequence", methods={"GET"})
     *
     *
     * @return Response
     */
    public function creerunesequence(Request $request):Response
    {
        $CategorieSequence = $this
            ->getDoctrine()
            ->getRepository(Categoriesequence::class);

        $firstCat = $CategorieSequence->findAll()[0];

        $sequenceTheorique = new Sequencetheorique();
        $sequenceTheorique->setTitre("Nouvelle séquence");
        $sequenceTheorique->setProprietaire($this->getUser());
        $sequenceTheorique->setPartage(false);
        $sequenceTheorique->setNiveau(1);
        $sequenceTheorique->setIdcategoriesequence($firstCat);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($sequenceTheorique);
        $entityManager->flush();

        return $this->json($sequenceTheorique,200,[],['groups'=>'sequence:lecture']);

    }



}