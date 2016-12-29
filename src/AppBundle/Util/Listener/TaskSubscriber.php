<?php

namespace AppBundle\Util\Listener;

use AppBundle\DTO\Task;
use AppBundle\Event\TaskEvent;
use AppBundle\Events;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use PGS\RabbitMQBundle\Publisher\PGSMessage;
use PGS\RabbitMQBundle\Service\RabbitMQPublisher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskSubscriber implements EventSubscriberInterface
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var RabbitMQPublisher
     */
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
            Events::TASK_ACTIVATED => 'onTaskActivated',
            Events::TASK_FLIP => 'onTaskFlip'
        ];
    }

    /**
     * @param TaskEvent $event
     */
    public function onTaskActivated(TaskEvent $event)
    {
        $message = $this->prepareMessage($event, 'task.active');
        $this->publisher->publish($message);
    }

    /**
     * @param TaskEvent $event
     */
    public function onTaskCreate(TaskEvent $event)
    {
        $message = $this->prepareMessage($event, 'task.created');
        $this->publisher->publish($message);
    }

    /**
     * @param TaskEvent $event
     */
    public function onTaskFlip(TaskEvent $event)
    {
        $message = $this->prepareMessage($event, 'task.flip');
        $this->publisher->publish($message);
    }

    /**
     * @param TaskEvent $event
     * @param string $topic
     *
     * @return PGSMessage
     */
    private function prepareMessage(TaskEvent $event, string $topic): PGSMessage
    {
        $task = Task::createFromEvent($event);
        $serializedTask = $this->serializer->serialize($task, 'json');
        $message = PGSMessage::createTopicMessage($serializedTask, 'poker', $topic);
        return $message;
    }

}
