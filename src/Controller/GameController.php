<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function game(): response
    {
        return $this->render('game.html.twig');
    }

    /**
     * @Route("/game-doc", name="game-doc")
     */
    public function doc(): response
    {
        $data = [
            'title' => 'Dokumentation',
        ];
        return $this->render('game\doc.html.twig', $data);
    }

    /**
    * @Route("/game-play", name="game-play")
    */
    public function play(Request $request, SessionInterface $session): response
    {
        $playArray = [];
        $bankArray = [];
        $points = array(0,0);
        $winner = -1;
        $indeck = 1;

        $shuffle  = $request->request->get('shuffle');
        $new      = $request->request->get('new');
        $hit      = $request->request->get('hit');
        $stand    = $request->request->get('stand');

        $cards = $session->get("cards") ?? new \App\Card\Deck();
        $deck = $cards->getDeck();
        if ($shuffle || $new) {
            $session->set("points", NULL);
            $session->set("playArray", NULL);
            $session->set("bankArray", NULL);
        }
        else {
            $points    = $session->get("points") ?? array(0,0);
            $playArray = $session->get("playArray") ?? [];
            $bankArray = $session->get("bankArray") ?? [];
        }

        if ($shuffle) {
            $cards = new \App\Card\Deck();
            $cards->shuffleDeck();
        } elseif ($new && $cards->noOfCardsInDeck()>1) {
            for ($i=0; $i<2; $i++) {
                array_push($playArray, $deck[$i]->showCard());
                $points[0] = $deck[$i]->getValue21($points[0]);
                $cards->drawCard();
            }
        } elseif ($hit && $cards->noOfCardsInDeck()>0) {
            array_push($playArray, $deck[0]->showCard());
            $points[0] = $deck[0]->getValue21($points[0]);
            $cards->drawCard();
            $winner = ($points[0]>21) ? 1 : -1;
        } elseif ($stand) {
            $cardbank = 0;
            while ($points[1]<17 && $cards->noOfCardsInDeck()>0) {
                array_push($bankArray, $deck[$cardbank]->showCard());
                $points[1] = $deck[$cardbank]->getValue21($points[1]);
                $cards->drawCard();
                $cardbank++;
            }
            $winner = ($points[1]>=$points[0] && $points[1]<=21);
        }

        if ($cards->noOfCardsInDeck()==0 || ($new && $cards->noOfCardsInDeck()==1)) {
            $this->addFlash("notice", "Omblandning måste ske; ej tillräckligt med kort kvar.");
            $indeck = ($cards->noOfCardsInDeck()>0);
        }

        $session->set("cards", $cards);
        $session->set("points", $points);
        $session->set("playArray", $playArray);
        $session->set("bankArray", $bankArray);

        $data = [
            'play' => $playArray,
            'bank' => $bankArray,
            'winner' => $winner,
            'indeck' => $indeck,
            'cardback' => $deck[0]->showCardBack(),
            'link_to_play' => $this->generateUrl('game-play')
        ];

        return $this->render('game\play.html.twig', $data);
    }
}
