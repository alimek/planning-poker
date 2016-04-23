<?php

namespace AppBundle\Controller;

use AppBundle\Document\Game;
use AppBundle\Form\GameType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class GamesController extends FOSRestController implements ClassResourceInterface
{
    public function cgetAction()
    {
    }

    /**
     * @Rest\View()
     */
    public function postAction(Request $request)
    {

        $form = $this->createForm(GameType::class);
        $form->submit($request->request);

        if ($form->isValid()) {
            $game = Game::create($request->get('name'));
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($game);
            $dm->flush();
        }

        $view = $this->view($game);

        return $this->handleView($view);
    }

    public function getAction($gameId)
    {
    }

}
