<?php

namespace AppBundle\Util\Listener;

use AppBundle\Event\TaskEvent;
use AppBundle\Events;
use JMS\Serializer\Serializer;
use PGS\RabbitMQBundle\Service\RabbitMQPublisher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskSubscriber implements EventSubscriberInterface
{
    protected $serializer;
    protected $publisher;

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
        $serializedTask = $this->serializer->serialize($event->getTask(), 'json');

        $this->publisher->publish(
            'poker',
            'task.created',
            $serializedTask
        );

    }
        
}
