<?php

namespace AppBundle\Util\Listener;

use AppBundle\Events;
use AppBundle\Model\Task;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskSubscriber implements EventSubscriberInterface
{
    /**
     * @var ProducerInterface
     */
    protected $producer;

    /**
     * @param ProducerInterface $producer
     */
    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
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
     * @param Task $task
     */
    public function onTaskCreate(Task $task)
    {
        
    }
        
}
