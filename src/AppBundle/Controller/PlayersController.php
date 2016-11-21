<?php
namespace AppBundle\Controller;

use AppBundle\Document\Player;
use AppBundle\Form\PlayerType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayersController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request): Response
    {
        $form = $this->createForm(PlayerType::class);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $playerModel = $form->getData();
            $player = Player::createFromModel($playerModel);

            $this->get('app.repositories.player_repository')->save($player);

            return $this->handleView($this->view($player, Response::HTTP_OK));
        }

        return $this->handleView($this->view($form));
    }
}
