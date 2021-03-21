<?php
namespace App\Controller;

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
}