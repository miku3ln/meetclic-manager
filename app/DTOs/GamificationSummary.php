<?php

namespace App\DTOs;
use App\DTOs\Rating;

class GamificationSummary
{
    public Yapitas $yapitas;
    public Yapitas $yapitasPremium;
    public Reputation $reputation;
    public Trophies $trophies;
    public Visits $visits;
    public Rating $rating;

    public function __construct(
        Yapitas $yapitas,
        Yapitas $yapitasPremium,
        Reputation $reputation,
        Trophies $trophies,
        Visits $visits,
        Rating $rating
    ) {
        $this->yapitas = $yapitas;
        $this->yapitasPremium = $yapitasPremium;
        $this->reputation = $reputation;
        $this->trophies = $trophies;
        $this->visits = $visits;
        $this->rating = $rating;
    }

    public function toArray(): array
    {
        return [
            'yapitas' => $this->yapitas->toArray(),
            'yapitas-premium' => $this->yapitasPremium->toArray(),
            'reputation' => $this->reputation->toArray(),
            'trophies' => $this->trophies->toArray(),
            'visits' => $this->visits->toArray(),
            'rating' => $this->rating->toArray(),
        ];
    }
}

