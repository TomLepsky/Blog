<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GameController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){}

    public function getItem($id, Request $request)
    {
        $game = $this->entityManager->getRepository(Game::class)->findBy(['slug' => $id]);
        if ($game === null || empty($game)) {
            throw new NotFoundHttpException("There is no game with such slug: {$id}.");
        }

        return $game;
    }

    public function getCollection() : ?Game
    {
        $game = $this->entityManager->getRepository(Game::class)->findBy([], ['weight' => 'DESC']);
    }
}
