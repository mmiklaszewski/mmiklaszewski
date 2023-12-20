<?php

namespace App\Domain\Exception;

final class CodeNotFound extends \Exception
{
    private function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(string $code): self
    {
        return new self(
            sprintf(
                'Code %s not found.',
                $code
            )
        );
    }
}
