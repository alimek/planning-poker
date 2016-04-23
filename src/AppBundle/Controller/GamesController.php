<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;

class GamesController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction()
    {
    }

    /**
     * @Rest\View()
     */
    public function postAction()
    {
        $game = new Game();
        $game->setHash('asdasas');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($game);
        $dm->flush();

        $view = $this->view($game);
        $view->setFormat('json');

        return $this->handleView($view);
    }

    public function getAction($gameId)
    {
    }

}
