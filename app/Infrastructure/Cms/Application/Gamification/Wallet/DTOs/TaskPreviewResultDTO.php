<?php

namespace App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs;

class TaskPreviewResultDTO
{
    public function __construct(
        public bool $success,
        public string $message,
        public ?array $data = null
    ) {}

    public static function ok(string $message, ?array $data = null): self
    {
        return new self(true, $message, $data);
    }

    public static function fail(string $message, ?array $data = null): self
    {
        return new self(false, $message, $data);
    }
}
