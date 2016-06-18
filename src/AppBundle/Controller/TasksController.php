<?php

namespace AppBundle\Controller;

use AppBundle\Document\Task;
use AppBundle\Form\TaskType;
use AppBundle\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package AppBundle\Controller
 */
class TasksController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return Task[]
     */
    public function cgetAction()
    {
        $tasks = $this->get('app.repositories.task_repository')->findAll();

        return $this->handleView($this->view($tasks, 200));
    }

    /**
     * @param Request $request
     * @return Form|Task
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(TaskType::class);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            /** @var Model\Task $taskModel */
            $taskModel = $form->getData();
            $task = Task::fromModel($taskModel);

            $this->get('app.repositories.task_repository')->save($task);

            return $this->handleView($this->view($task, 200));
        }

        return $this->handleView($this->view($form));
    }

    /**
     * @param $taskId
     * @return Task
     */
    public function getAction($taskId)
    {
        $task = $this->get('app.repositories.task_repository')->find($taskId);

        return $this->handleView($this->view($task, 200));
    }
}
