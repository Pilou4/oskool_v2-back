<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
        /**
         * @Route("/list", name="event_list")
         */
        public function list()
        {
        $repository = $this->getDoctrine()->getRepository(Events::class);
        $events = $repository->findAll();

            return $this->render('event/list.html.twig',
        [
            "events" => $events
        ]);
    }

        /**
         * @Route("/view/{id}", name="event_view",
         * requirements={"id"="\d+"})
         */
        public function view($id) 
        {
            /** @var Eventsrepository $repository */
            $repository = $this->getDoctrine()->getRepository(Events::class);
        $event = $repository->findbyEvent($id);

        return $this->render('event/view.html.twig',
        [
            "event" => $event
        ]);
    }
}
