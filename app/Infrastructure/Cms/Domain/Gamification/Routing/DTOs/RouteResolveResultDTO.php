<?php

namespace App\Infrastructure\Cms\Domain\Gamification\Routing\DTOs;

class RouteResolveResultDTO
{
    public function __construct(
        public bool $success,
        public string $message,
        public ?array $data = null
    ) {}

    public static function ok(string $message, array $data): self
    {
        return new self(true, $message, $data);
    }

    public static function fail(string $message): self
    {
        return new self(false, $message, null);
    }
}
