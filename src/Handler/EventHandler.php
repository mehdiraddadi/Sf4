<?php

namespace App\Handler;

use App\Entity\Event;
use App\Event\Events;
use App\Form\EventFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * EventHandler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher)
    {
        $this->em         = $em;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handler(Request $request)
    {
        $event = $request->attributes->get('data');
        if($event instanceof Event) {
            $this->em->persist($event);
            $this->em->flush();
            $event = new GenericEvent($event);
            $this->dispatcher->dispatch(Events::EVENT_REGISTERED, $event);
            return $event;
        }
    }
}