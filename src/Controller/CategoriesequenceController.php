<?php

namespace App\Controller;

use App\Entity\Categoriesequence;
use App\Form\CategoriesequenceType;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\ContainerParametersHelper;
/**
 * @Route("/categoriesequence")
 */
class CategoriesequenceController extends AbstractController
{
    /**
     * @Route("/", name="categoriesequence_index", methods={"GET"})
     */
    public function index(): Response
    {
        $categoriesequences = $this->getDoctrine()
            ->getRepository(Categoriesequence::class)
            ->findAll();

        return $this->render('categoriesequence/index.html.twig', [
            'categoriesequences' => $categoriesequences,
        ]);
    }

    /**
     * @Route("/new", name="categoriesequence_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, ContainerParametersHelper $pathHelpers): Response
    {
        $categoriesequence = new Categoriesequence();
        $form = $this->createForm(CategoriesequenceType::class, $categoriesequence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file = $form['image']->getData();
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            $dir = $pathHelpers->getApplicationRootDir()."/public/image/";
            $file->move($dir, $newFilename);

            $categoriesequence->setImage($newFilename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoriesequence);
            $entityManager->flush();

            return $this->redirectToRoute('categoriesequence_index');
        }

        return $this->render('categoriesequence/new.html.twig', [
            'categoriesequence' => $categoriesequence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoriesequence_show", methods={"GET"})
     */
    public function show(Categoriesequence $categoriesequence): Response
    {
        return $this->render('categoriesequence/show.html.twig', [
            'categoriesequence' => $categoriesequence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoriesequence_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categoriesequence $categoriesequence, SluggerInterface $slugger, ContainerParametersHelper $pathHelpers): Response
    {
        $form = $this->createForm(CategoriesequenceType::class, $categoriesequence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // $this->getDoctrine()->getManager()->flush();

            $file = $form['image']->getData();
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            $dir = $pathHelpers->getApplicationRootDir()."/public/image/";
            $file->move($dir, $newFilename);

            $categoriesequence->setImage($newFilename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoriesequence);
            $entityManager->flush();

            return $this->redirectToRoute('categoriesequence_index');
        }

        return $this->render('categoriesequence/edit.html.twig', [
            'categoriesequence' => $categoriesequence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoriesequence_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Categoriesequence $categoriesequence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoriesequence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoriesequence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categoriesequence_index');
    }
}
