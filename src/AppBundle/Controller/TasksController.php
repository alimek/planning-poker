<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use AppBundle\Document\Task;
use AppBundle\Form\TaskType;
use AppBundle\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ODM\MongoDB\LockException;

/**
 * @package AppBundle\Controller
 * @Rest\RouteResource("Game")
 *
 */
class TasksController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param $gameId
     * @return Response
     * @throws LockException
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
     * @param $gameId
     * @return Response
     * @throws LockException
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
     * @param $gameId
     * @param $taskId
     * @return Response
     * @throws LockException
     */
    public function getTaskAction($gameId, $taskId)
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $task = $game->getTaskById($taskId);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException();
        }

        return $this->handleView($this->view($task, 200));
    }

    /**
     * @param Request $request
     * @param $gameId
     * @param $taskId
     */
    public function patchFlipTaskAction(Request $request, $gameId, $taskId)
    {
        // TODO
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }



    }
    
}
