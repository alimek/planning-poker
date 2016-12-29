<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use AppBundle\Document\Player;
use AppBundle\Document\Vote;
use AppBundle\Event\CardPickEvent;
use AppBundle\Events;
use AppBundle\Form\CardPickType;
use AppBundle\Model\CardPick;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package AppBundle\Controller
 * @Rest\RouteResource("Game")
 *
 */
class VotesController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *     description="Get tasks for given game",
     *     resource=true,
     *     output="Task[]"
     * )
     * @param Request $request
     * @param string $gameId
     * @param string $playerId
     *
     * @return Response
     */
    public function patchPlayerPickAction(Request $request, string $gameId, string $playerId) {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        if(!$game instanceof Game) {
            throw new NotFoundHttpException('Game not found');
        }

        $player = $this->get('app.repositories.player_repository')->getPlayerByGUID($playerId);

        if(!$player instanceof Player) {
            throw new NotFoundHttpException('Player not found');
        }

        $form = $this->createForm(CardPickType::class);
        $form->submit($request->request->all());

        if($form->isValid()) {
            /** @var CardPick $cardPickModel */
            $cardPickModel = $form->getData();
            $task = $game->getTaskById($cardPickModel->getTaskId());
            $task->replaceVote(new Vote($player, $cardPickModel->getVote()));
            $this->get('app.repositories.game_repository')->save($game);
            $event = new CardPickEvent($game, $task, $cardPickModel->getVote(), $player);
            $this->get('event_dispatcher')->dispatch(Events::PLAYER_PICKED_CARD, $event);
        }

        return $this->handleView($this->view('OK', Response::HTTP_OK));
    }
}
