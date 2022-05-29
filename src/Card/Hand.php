<?php

namespace App\Card;

class Hand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

}
