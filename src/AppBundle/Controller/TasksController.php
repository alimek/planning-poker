<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use AppBundle\Document\Task;
use AppBundle\Event\TaskEvent;
use AppBundle\Events;
use AppBundle\Form\TaskType;
use AppBundle\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
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
     * @ApiDoc(
     *     description="Get tasks for given game",
     *     resource=true,
     *     output="Task[]"
     * )
     * @param string $gameId
     * @return Response
     * @throws LockException
     */
    public function cgetTasksAction(string $gameId): Response
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        return $this->handleView($this->view($game->getTasks(), Response::HTTP_OK));
    }

    /**
     * @ApiDoc(
     *     description="Create task in game",
     *     input={
     *          "class"="AppBundle\Form\TaskType",
     *          "name"=""
     *     },
     *     output="Task"
     * )
     * @param Request $request
     * @param string $gameId
     * @return Response
     * @throws LockException
     */
    public function postTaskAction(Request $request, string $gameId): Response
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

            if($game->getCurrentTaskId() === null) {
                $game->setCurrentTaskId($task->getId());
                $this->get('app.repositories.game_repository')->save($game);
            }

            $taskEvent = new TaskEvent($task, $game);
            $this->container->get('event_dispatcher')->dispatch(Events::TASK_CREATED, $taskEvent);

            return $this->handleView($this->view($task, Response::HTTP_OK));
        }

        return $this->handleView($this->view($form));
    }

    /**
     * @ApiDoc(
     *     description="Get single task"
     * )
     * @param string $gameId
     * @param string $taskId
     *
     * @return Response
     *
     * @throws LockException
     */
    public function getTaskAction(string $gameId, string $taskId): Response
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $task = $game->getTaskById($taskId);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException();
        }

        return $this->handleView($this->view($task, Response::HTTP_OK));
    }

    public function patchTaskActiveAction(string $gameId, string $taskId): Response {
        $gameRepository = $this->get('app.repositories.game_repository');
        $game = $gameRepository->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $task = $game->getTaskById($taskId);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException();
        }

        $game->setCurrentTaskId($task->getId());
        $gameRepository->save($game);

        $taskEvent = new TaskEvent($task, $game);
        $this->container->get('event_dispatcher')->dispatch(Events::TASK_ACTIVATED, $taskEvent);

        return $this->handleView($this->view($task, Response::HTTP_OK));
    }

    /**
     * @ApiDoc(
     *     description="Flip task"
     * )
     * @param string $gameId
     * @param string $taskId
     *
     * @return Response
     */
    public function patchTaskFlipAction(string $gameId, string $taskId): Response
    {
        $gameRepository = $this->get('app.repositories.game_repository');
        $game = $gameRepository->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $task = $game->getTaskById($taskId);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException();
        }

        $game->flipTask($taskId);
        $gameRepository->save($game);

        $taskEvent = new TaskEvent($task, $game);
        $this->container->get('event_dispatcher')->dispatch(Events::TASK_FLIP, $taskEvent);

        return $this->handleView($this->view($task, Response::HTTP_OK));
    }
    
}
