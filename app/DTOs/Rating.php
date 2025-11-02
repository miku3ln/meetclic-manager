<?php

namespace App\DTOs;

class Rating
{
    public int $positiveClients;
    public float $averageStars;
    public float $communityScore;

    public function __construct(int $positiveClients = 0, float $averageStars = 0.0, float $communityScore = 0.0)
    {
        $this->positiveClients = $positiveClients;
        $this->averageStars = $averageStars;
        $this->communityScore = $communityScore;
    }

    public function toArray(): array
    {
        return [
            'clients_satisfied' => $this->positiveClients,
            'average_stars' => round($this->averageStars, 2),
            'community_score' => round($this->communityScore, 2),
        ];
    }
}
