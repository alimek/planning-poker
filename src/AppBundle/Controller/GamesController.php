<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use AppBundle\Document\Player;
use AppBundle\Event\GameEvent;
use AppBundle\Event\PlayerEvent;
use AppBundle\Events;
use AppBundle\Form\GameType;
use AppBundle\Model;
use AppBundle\Event\PlayerStatusChangedEvent;
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

        return $this->handleView($this->view($games, Response::HTTP_OK));
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

            return $this->handleView($this->view($game, Response::HTTP_OK));
        }

        return $this->handleView($this->view($form));
    }

    /**
     * @ApiDoc(
     *     description="Get players for given game",
     *     resource=true,
     *     output="Player[]"
     * )
     * @param $gameId
     *
     * @return Response
     */
    public function cgetPlayersAction($gameId): Response
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $players = $this->get('app.repositories.player_repository')->getAllPlayersByGame($game);

        return $this->handleView($this->view($players, Response::HTTP_OK));
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

        return $this->handleView($this->view($game, Response::HTTP_OK));
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

        return $this->handleView($this->view([], Response::HTTP_OK));
    }

    /**
     * @param string $gameId
     * @param string $playerGUID
     *
     * @return Response
     */
    public function addPlayerAction(string $gameId, string $playerGUID): Response
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if(!$game instanceof Game) {
            throw new NotFoundHttpException('Game not found');
        }

        $player = $this->get('app.repositories.player_repository')->getPlayerByGUID($playerGUID);

        if(!$player instanceof Player) {
            throw new NotFoundHttpException('Player not found');
        }

        $game->addPlayer($player);
        $this->get('app.repositories.game_repository')->save($game);

        $playerStatusChangedEvent = PlayerStatusChangedEvent::createFromPlayer($player);
        $this->container->get('event_dispatcher')->dispatch(Events::PLAYER_ONLINE, $playerStatusChangedEvent);

        $playerEvent = new PlayerEvent($player, $game);
        $this->container->get('event_dispatcher')->dispatch(Events::PLAYER_JOINED_GAME, $playerEvent);

        return $this->handleView($this->view($player, Response::HTTP_OK));
    }
 }
