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
         /** @var Classesrepository */
         $repository = $this->getDoctrine()->getRepository(Classes::class);
         $classe = $repository->findall;
        return $this->render('classe/list.html.twig',
        [
            "classe" => $classe
        ]);

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

    /**
     * @Route("/update/{id}", name="classe_update", requirements={"id"="\d+"})
     */
    public function update($id, Request $request)
    {
        /** @var Classesrepository $repository */
        $repository = $this->getDoctrine()->getRepository(Classes::class);
        $classe = $repository->findByClasse($id);

        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager(); 
            $manager->flush();
            
            $this->addFlash("success", "La classe a bien été mise à jour");
            // je redirige vers la page qui affiche le detail de la series que l'on vient de modifier
            return $this->redirectToRoute('classe_view', ["id" => $classe->getId()]);
        }

        return $this->render(
            'classe/update.html.twig',
            [
                "classForm" => $form->createView(),
                "classe" => $classe
            ]
        );
    }

    /**
     * @Route("/delete/{id}", name="classe_delete", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        // 1 - on recupère l'entité à supprimer (param converter / repository)
        // Nous on l'a fait avec le param converter
        /** @var Classesrepository $repository */
        $repository = $this->getDoctrine()->getRepository(Classes::class);
        $classe = $repository->findByClasse($id);
        
        // 2 - on recupère le manager
        $manager = $this->getDoctrine()->getManager();

        if (!is_null($classe->getId())) {
            // 3 - on demande au manager de supprimer l'entité
            $manager->remove($classe);
            $manager->flush();

            // 4 - on met un message pour dire que ca s'est bien passé
            $this->addFlash("success", "La classe a bien été supprimée");
        }else {
            $this->addFlash("error", "La classe ne peut pas être supprimé !");
        }
        // 5 - on redirige vers une page qui montre l'effet (la liste des series, on va pouvoir voir que la serie n'y est plus)
        return $this->redirectToRoute('school_list');
    }
}

