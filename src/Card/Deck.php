<?php

namespace App\Card;

class Deck
{
    /**
    * @var array
    */
    protected $deck;

    /**
    *  Creates a standard deck of 52 playing cards
    */
    public function __construct()
    {
        $this->deck = array();
        $suits = array(
            'A','D','B','C'
        );
        $values = array(
            '1','2','3','4','5','6','7','8','9','A','B','D','E'
        );
        foreach($suits as $suit)
        {
            foreach($values as $value)
            {
                $card = new Card($suit, $value);
                array_push($this->deck ,$card);
            }
        }
    }

    public function getDeck() {
        return $this->deck;
    }

    public function drawCard() {
        return array_shift($this->deck);
    }

    public function shuffleDeck() {
        shuffle($this->deck);
    }

    public function noOfCardsInDeck() {
        return sizeof($this->deck);
    }

    public function getAsArray(): array
    {
        $deckArray = [];
        foreach ($this->deck as $drawn) {
            array_push($deckArray, $drawn->showCard());
        }
        return $deckArray;
    }

}
