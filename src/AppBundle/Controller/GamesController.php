<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use AppBundle\Form\GameType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model;

/**
 * @package AppBundle\Controller
 */
class GamesController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return Game[]
     */
    public function cgetAction()
    {
        $games = $this->get('app.repositories.game_repository')->findAll();

        return $this->handleView($this->view($games, 200));
    }

    /**
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
            $game = $gameModel->toDocument();

            $this->get('app.repositories.game_repository')->save($game);

            $producer = $this->get('old_sound_rabbit_mq.game_producer');
            $producer->setContentType('application/json');
            $producer->setRoutingKey('game.create');
            $producer->publish($this->get('serializer')->serialize($game, 'json'));

            return $this->handleView($this->view($game, 200));
        }

        return $this->handleView($this->view($form));
    }

    /**
     * @param string $gameId
     * @return Game
     */
    public function getAction($gameId)
    {
        $game = $this->get('app.repositories.game_repository')->find($gameId);

        return $this->handleView($this->view($game, 200));
    }
}
