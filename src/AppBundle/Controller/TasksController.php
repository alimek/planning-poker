<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use AppBundle\Document\Task;
use AppBundle\Form\TaskType;
use AppBundle\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package AppBundle\Controller
 * @Rest\RouteResource("Game")
 *
 */
class TasksController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return Task[]
     */
    public function cgetTasksAction($gameId)
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        return $this->handleView($this->view($game->getTasks(), 200));
    }

    /**
     * @param Request $request
     * @return Form|Task
     */
    public function postTaskAction(Request $request, $gameId)
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(TaskType::class);
        $form->submit($request->request->all());
        
        if ($form->isValid()) {

            /** @var Model\Task $taskModel */
            $taskModel = $form->getData();
            $task = Task::fromModel($taskModel);

            $game->addTask($task);

            $this->get('app.repositories.game_repository')->save($game);

            return $this->handleView($this->view($task, 200));
        }

        return $this->handleView($this->view($form));
    }

    /**
     * @param $taskId
     * @return Task
     */
    public function getTaskAction($gameId, $taskId)
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $task = $game->getTasks()->filter(function(Task $task) use ($taskId) {
            if ($task->getId()===$taskId) {
                return true;
            }

            return false;
        });

        return $this->handleView($this->view($task, 200));
    }
}
