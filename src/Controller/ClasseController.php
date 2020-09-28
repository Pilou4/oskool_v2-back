<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Schools;
use App\Form\ClasseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassesRepository;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/classe")
*/
class ClasseController extends AbstractController
{
    /**
     * @Route("/list", name="classe_list")
     */
    public function list()
    {
        return $this->render('classe/list.html.twig');
    }

    /**
     * @Route("/view/{id}", name="classe_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {
        /** @var Classesrepository */
        $repository = $this->getDoctrine()->getRepository(Classes::class);
        $classe = $repository->findByClasse($id);

        return $this->render('classe/view.html.twig',
        [
            "classe" => $classe
        ]
        );
    }

    /**
     * @Route("/add/{id}", name="classe_add", requirements={"id"="\d+"})
     */
    public function add(Schools $schools, Request $request)
    {
        $classe = new Classes();
        $classe->setSchools($schools);

        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($classe);
            $manager->flush();

            $this->addFlash("success", "La classe a bien été ajoutée");
            return $this->redirectToRoute("school_view", ["id" => $schools->getId()]);
        }

        return $this->render('classe/add.html.twig', [
            "classForm" => $form->createView()
        ]);
    }

}
