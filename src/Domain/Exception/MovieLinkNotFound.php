<?php

namespace App\Domain\Exception;

final class MovieLinkNotFound extends \Exception
{
    private function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(string $title): self
    {
        return new self(
            sprintf(
                'Link for title %s not found',
                $title
            )
        );
    }
}
