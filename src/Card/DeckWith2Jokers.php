<?php

namespace App\Card;

class DeckWith2Jokers extends Deck {
    public function __construct($numJokers = 2) {
        // Create a standard deck
        parent::__construct();

        // Add jokers
        for ($i = 0; $i < $numJokers; $i++) {
            $c = $i%2 ? 'B' : 'D';
            $this->deck[] = new Card($c, 'F');
        }
    }
}
