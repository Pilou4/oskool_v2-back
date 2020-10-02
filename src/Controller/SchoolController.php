<?php

namespace App\Controller;

use App\Repository\SchoolsRepository;
use App\Entity\Schools;
use App\Form\SchoolType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/school")
 */
class SchoolController extends AbstractController
{
    /**
     * @Route("/list", name="school_list")
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Schools::class);
        $schools = $repository->findAll();

        return $this->render('school/list.html.twig',
        [
            "schools" => $schools
        ]);
    }

    /**
     * @Route("/view/{id}", name="school_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {

         /** @var Schoolsrepository $repository */
        $repository = $this->getDoctrine()->getRepository(Schools::class);
        $school = $repository->findWithSchool($id);
        return $this->render(
            'school/view.html.twig',
             [
                 "school" => $school
             ]
        );
    }

    /**
     * @Route("/add", name="school_add", requirements={"id"="\d+"})
     */
    public function add(Request $request)
    {
        $school = new Schools();
        $schoolForm = $this->createForm(SchoolType::class, $school);
        $schoolForm->handleRequest($request);
        if($schoolForm->isSubmitted() && $schoolForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($school);
            $manager->flush();

            $this->addFlash("success", "L'école a bien été ajoutée");
            return $this->redirectToRoute("school_view", ["id" => $school->getId()]);
        }

        return $this->render('school/add.html.twig', [
            "schoolForm" => $schoolForm->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="school_update", requirements={"id"="\d+"})
     */
    public function update($id, Request $request)
    {
        /** @var Schoolsrepository $repository */
        $repository = $this->getDoctrine()->getRepository(Schools::class);
        $school = $repository->findWithSchool($id);
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager(); 
            $manager->flush();
            
            $this->addFlash("success", "L'école a bien été mise à jour");
            // je redirige vers la page qui affiche le detail de la series que l'on vient de modifier
            return $this->redirectToRoute('school_view', ["id" => $school->getId()]);
        }

        return $this->render(
            'school/update.html.twig',
            [
                "schoolForm" => $form->createView(),
                "school" => $school
            ]
        );
    }
    
    /**
     * @Route("/delete/{id}", name="school_delete", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        // 1 - on recupère l'entité à supprimer (param converter / repository)
        // Nous on l'a fait avec le param converter
        /** @var Schoolsrepository $repository */
        $repository = $this->getDoctrine()->getRepository(Schools::class);
        $school = $repository->findWithSchool($id);


        // 2 - on recupère le manager
        $manager = $this->getDoctrine()->getManager();

        // 3 - on demande au manager de supprimer l'entité
        $manager->remove($school);
        $manager->flush();

        // 4 - on met un message pour dire que ca s'est bien passé
        $this->addFlash("success", "L'école a bien été supprimée");

        // 5 - on redirige vers une page qui montre l'effet (la liste des series, on va pouvoir voir que la serie n'y est plus)
        return $this->redirectToRoute('school_list');
    }
}