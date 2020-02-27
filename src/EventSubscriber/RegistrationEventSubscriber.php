<?php

namespace App\EventSubscriber;

use App\Entity\Event;
use App\Entity\User;
use App\Event\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use OldSound\RabbitMqBundle\RabbitMq\Producer;

/**
 * Envoi un mail de bienvenue à chaque creation d'un utilisateur
 *
 */
class RegistrationEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var Producer
     */
    private $producer;

    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::EVENT_REGISTERED => 'onEventRegistred',
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function onEventRegistred(GenericEvent $event): void
    {
        /** @var Event $event */
        $event = $event->getSubject();

        $message = (new \Swift_Message('Sujet de l\'email'))
            ->setFrom('mehdiraddadi@gmail.com')
            ->setTo('mehdiraddadi@gmail.com')
            ->setBody('Hello You!', 'text/html');

        $this->producer->publish(serialize($message));
    }
}