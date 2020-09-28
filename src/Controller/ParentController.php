<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Repository\ParentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("/parent")
     */
class ParentController extends AbstractController
{
    /**
     * @Route("/list", name="parent_list")
     */
    public function index()
    {
        return $this->render('parent/list.html.twig');
    }
    /**
     * @Route("/view/{id}", name="parent_view", requirements={"id"="\d+"})
     */
    public function view($id)
    {
        /** @var Parentsrepository */
        $repository = $this->getDoctrine()->getRepository(Parents::class);
        $parent = $repository->findByParent($id);

        return $this->render('parent/view.html.twig',
        [
            "parent" => $parent
        ]
        );
    }
}
