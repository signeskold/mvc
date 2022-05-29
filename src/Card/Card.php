<?php

namespace App\Card;

class Card {
    protected $suit;
    protected $value;

    public function __construct($suit, $val) {
        $this->suit = $suit;
    	$this->value = $val;
    }

    public function getValue21(int $hand) {
        if ($this->value=='A' ||
            $this->value=='B' ||
            $this->value=='D' ||
            $this->value=='E') {
                $val = 10;
        }
        else {
            $val = $this->value;
        }
        if ($val==1 && $hand<11) {
            $val += 10;
        }
        return $val + $hand;
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
