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
     * @ApiDoc(
     *     description="Create task in game",
     *     input={
     *          "class"="AppBundle\Form\TaskType",
     *          "name"=""
     *     },
     *     output="Task"
     * )
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
            
            $taskEvent = new TaskEvent($game, $task);
            $this->get('event_dispatcher')->dispatch(Events::TASK_CREATED, $taskEvent);

            return $this->handleView($this->view($task, 200));
        }

        return $this->handleView($this->view($form));
    }

    /**
     * @ApiDoc(
     *     description="Get single task"
     * )
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
     * @ApiDoc(
     *     description="Flip task (not finished)"
     * )
     * @param Request $request
     * @param $gameId
     * @param $taskId
     */
    public function patchFlipAction(Request $request, $gameId, $taskId)
    {
        // TODO
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }



    }
    
}
