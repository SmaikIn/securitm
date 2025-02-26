<?php

namespace app\Services\User\Exceptions;

use JetBrains\PhpStorm\Pure;
use RuntimeException;
use Throwable;

class ServiceException extends RuntimeException
{
    /**
     * @var string
     */
    private string $userMessage;

    #[Pure] public function __construct(string $userMessage, int $code = 0, Throwable $previous = null)
    {
        $this->userMessage = $userMessage;
        parent::__construct('Service exception', $code, $previous);
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }
}
