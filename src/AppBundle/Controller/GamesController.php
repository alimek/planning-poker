<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use AppBundle\Event\GameEvent;
use AppBundle\Events;
use AppBundle\Form\GameType;
use AppBundle\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package AppBundle\Controller
 */
class GamesController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Get all games"
     * )
     * @return Response
     */
    public function cgetAction(): Response
    {
        $games = $this->get('app.repositories.game_repository')->findAll();

        return $this->handleView($this->view($games, 200));
    }

    /**
     * @ApiDoc(
     *     description="Create new game",
     *     input={
     *          "class"="AppBundle\Form\GameType",
     *          "name" = ""
     *     },
     *     output="Game"
     * )
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request): Response
    {
        $form = $this->createForm(GameType::class);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            /** @var Model\Game $gameModel */
            $gameModel = $form->getData();
            $game = Game::fromModel($gameModel);

            $this->get('app.repositories.game_repository')->save($game);

            $gameEvent = new GameEvent($game);
            $this->get('event_dispatcher')->dispatch(Events::GAME_CREATED, $gameEvent);

            return $this->handleView($this->view($game, 200));
        }

        return $this->handleView($this->view($form));
    }

    /**
     * @ApiDoc(
     *     description="Get single game",
     *     resource=true,
     *     output="Game"
     * )
     * @param string $gameId
     *
     * @return Response
     */
    public function getAction(string $gameId): Response
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        return $this->handleView($this->view($game, 200));
    }

    /**
     * @ApiDoc(
     *     description="Start game"
     * )
     * @param string $gameId
     *
     * @return Response
     */
    public function patchStartAction(string $gameId): Response
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $game->startGame();
        $this->get('app.repositories.game_repository')->save($game);

        $gameEvent = new GameEvent($game);
        $this->get('event_dispatcher')->dispatch(Events::GAME_STARTED, $gameEvent);

        return $this->handleView($this->view([], 200));
    }
}
