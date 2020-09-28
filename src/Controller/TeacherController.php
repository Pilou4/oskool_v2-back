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
        return $this->render('teacher/list.html.twig');
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
     * @Route("/add/{id}", name="teacher_add", requirements={"id"="\d+"})
     */
    public function add(Classes $classe, Request $request)
    {
        $teacher = new Teachers();
        $teacher->addClass($classe);

        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();

            $this->addFlash("success", "La classe a bien été ajoutée");
            return $this->redirectToRoute("classe_view", ["id" => $classe->getId()]);
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
            return $this->redirectToRoute("classe_list");
        }

        return $this->render('teacher/update.html.twig', [
            "teacherForm" => $form->createView()
        ]);
    }
}
