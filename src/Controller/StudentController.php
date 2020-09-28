<?php

namespace App\Controller;

use App\Entity\Schools;
use App\Entity\Students;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentsRepository;
use App\Service\Uploader;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController
{



    /**
     * @Route("/list", name="student_list")
     */
    public function list()
    {
        /** @var Studentrepository */
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $students = $repository->findAll();
        return $this->render('student/list.html.twig', 
        [
            "students" => $students
        ]);
    }

    /**
    * @Route("/view/{id}", name="student_view", requirements={"id"="\d+"})
    */
    public function view($id)
    {
        /** @var Studentsrepository */
        $repository = $this->getDoctrine()->getRepository(Students::class);
        $student = $repository->findByStudent($id);

        return $this->render('student/view.html.twig',
            [
                "student" => $student
            ]
        );
    }


    

    /**
     * @Route("/add/{id}", name="student_add", requirements={"id"="\d+"})
     */
    public function add(Students $student, Request $request)
    {
                
    }
}
