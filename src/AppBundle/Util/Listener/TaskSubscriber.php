<?php

namespace AppBundle\Util\Listener;

use AppBundle\DTO\Task;
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
    public static function getSubscribedEvents(): array
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
        $task = Task::createFromEvent($event);
        $serializedTask = $this->serializer->serialize($task, 'json');

        $this->publisher->publish(
            'poker',
            'task.created',
            $serializedTask
        );
    }
        
}
