<?php

namespace AppBundle\Util\Listener;

use AppBundle\Event\TaskEvent;
use AppBundle\Events;
use JMS\Serializer\Serializer;
use PGS\RabbitMQBundle\Service\RabbitMQPublisher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskCreatedSubscriber implements EventSubscriberInterface
{
    /**
     * @var RabbitMQPublisher
     */
    private $publisher;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param RabbitMQPublisher $publisher
     * @param Serializer $serializer
     */
    public function __construct(RabbitMQPublisher $publisher, Serializer $serializer)
    {
        $this->publisher = $publisher;
        $this->serializer = $serializer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::TASK_CREATED => 'onTaskCreate',
        ];
    }

    /**
     * @param TaskEvent $event
     */
    public function onTaskCreate(TaskEvent $event)
    {
        $this->publisher->publish(
            'game',
            'game.task.created',
            $this->serializer->serialize($event->getTask(), 'json')
        );
    }

}
