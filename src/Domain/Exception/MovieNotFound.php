<?php

namespace App\Domain\Exception;

use Symfony\Component\Uid\Uuid;

final class MovieNotFound extends \Exception
{
    private function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(Uuid $uuid): self
    {
        return new self(
            sprintf(
                'Movie entity with uuid %s not found',
                $uuid->jsonSerialize()
            )
        );
    }
}
