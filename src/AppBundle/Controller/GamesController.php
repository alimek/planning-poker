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
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
     * @return Game[]
     */
    public function cgetAction()
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
     * @return Form|Game
     */
    public function postAction(Request $request)
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
     * @return Game
     */
    public function getAction($gameId)
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        return $this->handleView($this->view($game, 200));
    }

    /**
     * @ApiDoc(
     *     description="Start game"
     * )
     * @param string $gameId
     * @return Game
     */
    public function patchStartAction($gameId)
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);
        
        if (!$game instanceof Game) {
            throw new NotFoundHttpException();
        }

        $this->get('app.util_manager.game_manager')->startGame($game);

        return $this->handleView($this->view([], 200));

    }
}
