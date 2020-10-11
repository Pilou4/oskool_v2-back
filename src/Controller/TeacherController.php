<?php

namespace App\Controller;

use App\Entity\Teachers;
use App\Entity\Classes;
use App\Repository\TeachersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TeacherType;


/**
 * @Route("/teacher")
 */
class TeacherController extends AbstractController
{

    /**
     * @Route("/list", name="teacher_list")
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Teachers::class);
        $teachers = $repository->findAll();
        return $this->render('teacher/list.html.twig',
            [
                'teachers' => $teachers
            ]
        );
    }

    /**
     * @Route("/view/{id}", name="teacher_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {
        /** @var Teachersrepository */
        $repository = $this->getDoctrine()->getRepository(Teachers::class);
        $teacher = $repository->findByTeacher($id);

        return $this->render('teacher/view.html.twig',
            [
                "teacher" => $teacher
            ]
        );
    }

    /**
     * @Route("/add", name="teacher_add", requirements={"id"="\d+"})
     */
    public function add(Request $request)
    {
        $teacher = new Teachers();
        // $teacher->addClass($classe);

        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();

            $this->addFlash("success", "L'enseigant a bien été ajoutée");
            return $this->redirectToRoute("teacher_view", ["id" => $teacher->getId()]);
        }

        return $this->render('teacher/add.html.twig', [
            "teacherForm" => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="teacher_update", requirements={"id"="\d+"})
     */
    public function update(Teachers $teacher, Request $request)
    {
    
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();

            $this->addFlash("success", "L'enseignant a bien été modifié");
            return $this->redirectToRoute("teacher_list");
        }

        return $this->render('teacher/update.html.twig', [
            "teacherForm" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="teacher_delete", requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        // 1 - on recupère l'entité à supprimer (param converter / repository)
        // Nous on l'a fait avec le param converter
        /** @var Teachersrepository $repository */
        $repository = $this->getDoctrine()->getRepository(Teachers::class);
        $teacher = $repository->findByTeacher($id);


        // 2 - on recupère le manager
        $manager = $this->getDoctrine()->getManager();

        // 3 - on demande au manager de supprimer l'entité
        $manager->remove($teacher);
        $manager->flush();

        // 4 - on met un message pour dire que ca s'est bien passé
        $this->addFlash("success", "L'enseignant a bien été supprimée");

        // 5 - on redirige vers une page qui montre l'effet (la liste des series, on va pouvoir voir que la serie n'y est plus)
        return $this->redirectToRoute('teacher_list');
    }
}
