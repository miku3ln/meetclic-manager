<?php

namespace App\Services\Gamification;

use Exception;

class DomainValidationException extends Exception
{
    private array $errors;
    private array $context;

    public function __construct(
        string $message = "Domain validation failed",
        array $errors = [],
        array $context = [],
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
        $this->context = $context;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function context(): array
    {
        return $this->context;
    }
}
