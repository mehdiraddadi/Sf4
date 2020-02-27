<?php

namespace AppBundle\Mailer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class MailerConsumer
 */
class MailerConsumer implements ConsumerInterface
{
    /**
     * @inheritdoc
     */
    public function execute(AMQPMessage $msg)
    {
        /** @var \Swift_Message $email */
        $email = unserialize($msg->getBody());

        echo 'L\'email suivant a été consomé : ', $email->getBody(), PHP_EOL, PHP_EOL;
    }
}