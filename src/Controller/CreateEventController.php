<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Handler\EventHandler;

class CreateEventController
{
    /**
     * @var EventHandler
     */
    private $eventHandler;

    /**
     * CreateEventController constructor.
     * @param EventHandler $eventHandler
     */
    public function __construct(EventHandler $eventHandler)
    {
        $this->eventHandler = $eventHandler;
    }

    /**
     * @Route(
     *     name="events_post_publication",
     *     path="/events",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=Event::class,
     *         "_api_item_operation_name"="post_publication"
     *     }
     * )
     */
    public function __invoke(Request $request)
    {
        $handler = $this->eventHandler->handler($request);
        return $handler;
    }
}