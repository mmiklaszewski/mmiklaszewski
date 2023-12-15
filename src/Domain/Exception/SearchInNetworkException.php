<?php

namespace App\Domain\Exception;

final class SearchInNetworkException extends \Exception
{
    private function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(string $reason): self
    {
        return new self(
            sprintf(
                'Exception during search in network, reason: %s',
                $reason
            )
        );
    }
}
