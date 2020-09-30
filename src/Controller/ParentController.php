<?php

namespace App\Controller;

use App\Entity\Parents;
use App\Repository\ParentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ParentType;

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
    /**
     * @Route("/add", name="parent_add", requirements={"id"="\d+"})
     */
    public function add(Request $request)
    {
        $parent = new Parents();
        $form = $this->createForm(ParentType::class, $parent);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($parent);
            $manager->flush();

            $this->addFlash("success", "Vous êtes bien inscrit");
            return $this->redirectToRoute("school_list");
        }

        return $this->render('parent/add.html.twig', [
            "parentForm" => $form->createView()
        ]);
    }
}
