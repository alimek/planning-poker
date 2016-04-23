<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GamesController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction()
    {
    }

    public function postAction()
    {
        $game = new Game();
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($game);
        $dm->flush();

        $view = View::create();

//        $view->setFormat();

        $view->setData($game);
        return $view->get();
    }

    public function getAction($gameId)
    {
    }

}
