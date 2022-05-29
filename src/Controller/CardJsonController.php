<?php

namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CardJsonController
{
    /**
    * @Route("/card/api/deck", name="card-api-deck")
    */
    public function deckjson(): response
    {
        $cards = new \App\Card\Deck();
        $data = [
            'title' => 'Sorterad kortlek',
            'deck' => $cards->getAsArray()
        ];
        $response = new JsonResponse();
        $response->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_PRETTY_PRINT);
        $response->setData([$data]);
        return $response;
    }

    /**
    * @Route("/card/api/deck/shuffle", name="card-api-deck-shuffle")
    */
    public function shufflejson(SessionInterface $session): response
    {
        $cards = new \App\Card\Deck();
        $cards->shuffleDeck();
        $session->set("cards", NULL);
        $session->set("table", NULL);
        $session->set("deal", NULL);
        $session->set("noofhands", NULL);
        $session->set("cardsinhand", NULL);
        $data = [
            'title' => 'Blandad kortlek',
            'deck' => $cards->getAsArray()
        ];

        $response = new JsonResponse();
        $response->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_PRETTY_PRINT);
        $response->setData([$data]);
        return $response;
    }

    /**
    * @Route("/card/api/deck/draw", name="card-api-deck-draw", methods={"GET", "POST"})
    */
    public function drawjson (SessionInterface $session): response
    {
        $tableArray = [];
        if ($session->get("cards")) {
            $cards = $session->get("cards");
        }
        else {
            $cards = new \App\Card\Deck();
            $cards->shuffleDeck();
        }
        $cardsInDeck = $cards->noOfCardsInDeck();
        if ($cardsInDeck > 0) {
            $deck = $cards->getDeck();
            if ($session->get("table")) {
                $tableArray = $session->get("table");
            }
            array_push($tableArray, $deck[0]->showCard());
            $deck = $cards->drawCard();

            $cardsInDeck--;
            $session->set("cards", $cards);
            $session->set("table", $tableArray);
        }
        $data = [
            'title' => 'Dra ett kort',
            'left' => $cardsInDeck,
            'table' => $tableArray
        ];

        $response = new JsonResponse();
        $response->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_PRETTY_PRINT);
        $response->setData([$data]);
        return $response;
    }

    /**
    * @Route("/card/api/deck/draw/{cardsToDraw}", name="card-api-deck-draw-number", methods={"GET", "POST"})
    */
    public function drawnumberjson(SessionInterface $session, int $cardsToDraw = 1): response
    {
        $tableArray = [];
        //$cardsToDraw = $request->request->get('number') ?? 0;
        if ($session->get("cards")) {
            $cards = $session->get("cards");
        }
        else {
            $cards = new \App\Card\Deck();
            $cards->shuffleDeck();
        }
        $cardsInDeck = $cards->noOfCardsInDeck();
        if ($cardsInDeck >= $cardsToDraw) {
            $deck = $cards->getDeck();
            if ($session->get("table")) {
                $tableArray = $session->get("table");
            }
            for ($i = 0; $i < $cardsToDraw; $i++) {
                array_push($tableArray, $deck[$i]->showCard());
            }
            for ($i = 0; $i < $cardsToDraw; $i++) {
                $deck = $cards->drawCard();
            }

            $cardsInDeck = $cards->noOfCardsInDeck();
            $redraw = 1;
            $session->set("cards", $cards);
            $session->set("table", $tableArray);
        }
        $data = [
            'title' => 'Dra kort',
            'left' => $cardsInDeck,
            'table' => $tableArray
        ];

        $response = new JsonResponse();
        $response->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_PRETTY_PRINT);
        $response->setData([$data]);
        return $response;
    }

    /**
    * @Route("/card/api/deck/deal/{cardsInHand}/{noOfHands}", name="card-api-deck-deal-players-cards", methods={"GET", "POST"}
    * )
    */
    public function deal(SessionInterface $session, int $cardsInHand=1, int $noOfHands=1): response
    {
        if ($session->get("cardsinhand" || $cardsInHand!=1)) {
            $cardsInHand = $session->get("cardsinhand");
        }
        if ($session->get("noofhands"  || $noOfHands!=1)) {
            $noOfHands = $session->get("noofhands");
        }
        $cardsInDeal = $cardsInHand * $noOfHands;
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

        if ($cardsInDeck >= $cardsInDeal) {
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
            'table' => $tableArray
        ];

        $response = new JsonResponse();
        $response->setEncodingOptions(JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_PRETTY_PRINT);
        $response->setData([$data]);
        return $response;
    }

}
