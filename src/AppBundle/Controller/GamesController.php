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
        $em = $this->get('doctrine_mongodb')->getManager();
        $games = $em->getRepository(Game::class)->findAll();

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

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($game);
            $dm->flush();

//            try {
//                $producer = $this->get('old_sound_rabbit_mq.game_producer');
//                $producer->setContentType('application/json');
//                $producer->setRoutingKey('game.create');
//                $producer->publish($gameModel->toMessage());
//            } catch (\Exception $e) {
//                $this->get('logger')->error($e->getMessage());
//            }

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
        $em = $this->get('doctrine_mongodb')->getManager();
        $game = $em->getRepository(Game::class)->find($gameId);

        return $this->handleView($this->view($game, 200));
    }
}
