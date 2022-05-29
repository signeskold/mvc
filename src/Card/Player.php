<?php

namespace App\Card;

use App\Card\Card;

class Player
{
    private $player = [];

    public function add(Hand $hand): void
    {
        $this->player[] = $hand;
    }

}
