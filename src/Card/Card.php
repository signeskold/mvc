<?php

namespace App\Card;

class Card {
    protected $suit;
    protected $value;

    public function __construct($suit, $val) {
        $this->suit = $suit;
    	$this->value = $val;
    }

    public function showCard() {
        // Build unicode string
        $unicode = "&#x1F0" . $this->suit . $this->value;
        return $unicode;
    }
    public function showCardBack() {
        return "&#x1F0A0;";
    }

}
