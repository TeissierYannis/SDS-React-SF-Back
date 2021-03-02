<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionFormulaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Zend\Code\Scanner\Util;
use App\Security\FormLoginAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;


class SecurityController extends AbstractController
{


    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encoder ): Response
    {
        //Request : la requête http est les différentes data associée
        //$encoder : un objet fournit automatiquement par symfony sachant encoder les mots de passe

        //Gestion du formulaire pour une nouvelle inscription
        $utilisateur = new Utilisateur(); //Création de l'utilisateur vierge pour alimenter le formulaire d'interface
        $formUtilisateur = $this->createForm( InscriptionFormulaire::class, $utilisateur);
        $formUtilisateur->handleRequest($request); //On demande au formulaire "InscriptionFormulaire" de gérer la requête HTTP. Il paramétrera si possible $utilisateur avec les datas de la requête HTTP.
        $error_inscription ="";


        if ($formUtilisateur->isSubmitted() && $formUtilisateur->isValid()) {
            $password = $formUtilisateur->get('password')->getData();
            if($password   ==  $formUtilisateur->get('passwordConfirm')->getData())
            {
                $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
                $users = $repository->findBy(
                    ['login' => $utilisateur->getLogin()]
                );
                if (count($users) == 0) {
                    $users = $repository->findBy(
                        ['email' => $utilisateur->getEmail()]
                    );
                    if (count($users) == 0) {

                        //On est bon!! on peut envoyer l'utilisateur en base de données. Par défaut, il a le rôle : ROLE_USER (utilisateur de base)

                        //paramétrages complémentaire de l'objet utilisateur
                        $passEncode = $encoder->encodePassword($utilisateur, $password); //Encodage du mot de passe
                        $utilisateur->setPassword($passEncode);
                        $utilisateur->setRoles(['ROLE_USER']);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($utilisateur);
                        $em->flush();


                        //Connexion manuelle de l'utilisateur nouvellement créé (merci google !)
                        $token = new UsernamePasswordToken($utilisateur, null, 'main', $utilisateur->getRoles());
                        $this->get('security.token_storage')->setToken($token);
                        // If the firewall name is not main, then the set value would be instead:
                        // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
                        $this->get('session')->set('_security_main', serialize($token));
                        // Fire the login event manually
                        $event = new InteractiveLoginEvent($request, $token);
                        $dispatcher = new EventDispatcher();
                        $dispatcher->dispatch($event,"security.interactive_login" );


                        return $this->render('accueil/base.html.twig', [
                                'utilisateur' => $this->getUser()
                            ]
                        );
                    } else
                        $error_inscription = "Mail déjà inscrit.";

                } else
                    $error_inscription = "Login déjà pris.";
            }
            else
                $error_inscription = "Erreur confirmation mot de passe";
        }

        //Si on arrive là, c'est que l'utilisateur n'a pas essayé de se connecter ni de s'inscrire
        return $this->render('security/formulaireConnexion.html.twig', [
                'last_username' => "",
                'error' => "",
                'error_inscription' => $error_inscription,
                'formUtilisateur' => $formUtilisateur->createView()
            ]
        );
    }


    /**
     * @Route("/", name="default")
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $utilisateur = new Utilisateur();
        $formUtilisateur = $this->createForm( InscriptionFormulaire::class, $utilisateur);

        return $this->render('security/formulaireConnexion.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
                'error_inscription' => "",
                'formUtilisateur' => $formUtilisateur->createView()
            ]
        );
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }



    /**
     * @Route("/pageaccueil", name="pageaccueil")
     */
    public function accueil(): Response
    {
        return $this->render('accueil/base.html.twig' );


    }
}
