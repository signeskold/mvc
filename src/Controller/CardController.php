<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CardController extends AbstractController
{

    /**
    * @Route("/card/deck", name="card-deck")
    */
    public function deck(): response
    {
        $cards = new \App\Card\Deck();
        $data = [
            'title' => 'Sorterad kortlek',
            'deck' => $cards->getAsArray()
        ];
        return $this->render('card\card.html.twig', $data);
    }

    /**
    * @Route("/card/deck/shuffle", name="card-deck-shuffle")
    */
    public function shuffle(SessionInterface $session): response
    {
        $cards = new \App\Card\Deck();
        $cards->shuffleDeck();
        $session->set("cards", $cards);
        $session->set("cardsOnTable", 0);
        $session->set("deal", NULL);
        $session->set("table", NULL);
        $session->set("noofhands", NULL);
        $session->set("cardsinhand", NULL);
        $data = [
            'title' => 'Blandad kortlek',
            'deck' => $cards->getAsArray()
        ];

        return $this->render('card\card.html.twig', $data);
    }

    /**
    * @Route("/card/deck/draw", name="card-deck-draw", methods={"GET", "POST"})
    */
    public function draw (Request $request,SessionInterface $session): response
    {
        if ($session->get("cards")) {
            $cards = $session->get("cards");
            $cardsOnTable = $session->get("cardsOnTable");
            if ($cardsOnTable < $cards->noOfCardsInDeck()) {
                $cardsOnTable++;
                $session->set("cardsOnTable", $cardsOnTable);
            }
            else {
                $this->addFlash("notice", "Du måste blanda om; inga kort kvar.");
            }
        }
        else {
            $this->addFlash("notice", "Du måste först blanda kortleken.");
            $cardsOnTable = 0;
            $cards = new \App\Card\Deck();
        }
        $deck = $cards->getDeck();
        $redraw = 0;
        $data = [
            'title' => 'Dra ett kort',
            'ontable' => $cardsOnTable,
            'indeck' => $cards->noOfCardsInDeck() - $cardsOnTable,
            'table' => $cards->getAsArray(),
            'redraw' => $redraw,
            'cardback' => $deck[0]->showCardBack()
        ];

        return $this->render('card\draw.html.twig', $data);
    }

    /**
    * @Route("/card/deck/draw/:number", name="card-deck-draw-number", methods={"GET", "POST"})
    */
    public function drawnumber(Request $request, SessionInterface $session): response
    {
        $cardsToDraw = $request->request->get('number') ?? 0;
        $redraw = 0;
        if ($session->get("cards")) {
            $cards = $session->get("cards");
            $cardsOnTable = $session->get("cardsOnTable");
            if ($cardsToDraw > $cards->noOfCardsInDeck() - $cardsOnTable) {
                $this->addFlash("warning", "Det finns inte tillräckligt med kort kvar.");
            }
            else if ($cardsOnTable < $cards->noOfCardsInDeck()) {
                $cardsOnTable += $cardsToDraw;
                $session->set("cardsOnTable", $cardsOnTable);
                $redraw = 1;
            }
            else {
                $this->addFlash("notice", "Du måste blanda om; inga kort kvar.");
            }
        }
        else {
            $this->addFlash("notice", "Du måste först blanda kortleken.");
            $cardsOnTable = 0;
            $cards = new \App\Card\Deck();
        }
        $deck = $cards->getDeck();
        $data = [
            'title' => 'Dra kort',
            'ontable' => $cardsOnTable,
            'indeck' => $cards->noOfCardsInDeck() - $cardsOnTable,
            'table' => $cards->getAsArray(),
            'redraw' => $redraw,
            'cardback' => $deck[0]->showCardBack(),
            'link_to_draw' => $this->generateUrl('card-deck-draw-number', ['number' => $cardsToDraw]),
        ];

        return $this->render('card\draw.html.twig', $data);
    }

    /**
    * @Route("/card/deck/deal/:players/:cards", name="card-deck-deal-players-cards", methods={"GET", "POST"}
    * )
    */
    public function deal(Request $request, SessionInterface $session): response
    {
        if (!$session->get("cardsinhand")) {
            $cardsInHand = $request->request->get('cards') ?? 0;
        }
        else {
            $cardsInHand = $session->get("cardsinhand");
        }
        if (!$session->get("noofhands")) {
            $noOfHands = $request->request->get('players') ?? 0;
        }
        else {
            $noOfHands = $session->get("noofhands");
        }
        $cardsInDeal = $cardsInHand * $noOfHands;
        $redraw = 0;
        $handArray = [];
        $tableArray = [];
        reset($handArray);
        reset($tableArray);
        $player = new \App\Card\Player();
        $hand = new \App\Card\Hand();
        if ($session->get("cards")) {
            $cards = $session->get("cards");
        }
        else {
            $cards = new \App\Card\Deck();
            $cards->shuffleDeck();
        }
        $deck = $cards->getDeck();
        $cardsInDeck = $cards->noOfCardsInDeck();

        if ($cardsInHand == 0 && $noOfHands == 0) {
            $redraw = 1;
            $this->addFlash("notice", "Välj antal spelare och kort för att börja spela!");
        } elseif ($cardsInDeck < $cardsInDeal) {
            $this->addFlash("warning", "Det finns inte tillräckligt med kort kvar.");
            $redraw = 2;
        } elseif ($cardsInDeck >= $cardsInDeal) {
            if ($session->get("deal")) {
                $tableArray = $session->get("deal");
            }
            for ($j = 0; $j < $noOfHands; $j++) {
                $hand = new \App\Card\Hand();
                $handArray = [];
                for ($i = 0; $i < $cardsInHand; $i++) {
                    array_push($handArray, $deck[$i+$j*$cardsInHand]->showCard());
                }
                $player->add($hand);
                array_push($tableArray, $handArray);
            }
            for ($i = 0; $i < $cardsInDeal; $i++) {
                $deck = $cards->drawCard();
            }
        }
        $cardsInDeck = $cards->noOfCardsInDeck();

        $session->set("cards", $cards);
        $session->set("table", $tableArray);
        $session->set("cardsinhand", $cardsInHand);
        $session->set("noofhands", $noOfHands);

        $data = [
            'title' => 'Giv',
            'left' => $cardsInDeck,
            'players' => $noOfHands,
            'cards' => $cardsInHand,
            'table' => $tableArray,
            'redraw' => $redraw,
            'link_to_play' => $this->generateUrl('card-deck-deal-players-cards',
                ['cards' => $cardsInHand, 'players' => $noOfHands]),
        ];

        return $this->render('card\deal.html.twig', $data);
    }

    /**
    * @Route("/card/deck2", name="card-deck2")
    */
    public function deck2(): response
    {
        $cards = new \App\Card\DeckWith2Jokers();
        $data = [
            'title' => 'Sorterad kortlek med två jokrar',
            'deck' => $cards->getAsArray()
        ];

        return $this->render('card\card.html.twig', $data);
    }

}
