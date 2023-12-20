<?php

namespace App\Application\Query\GetCode;

use App\Infrastructure\Entity\Code;

final readonly class CodeView implements \JsonSerializable
{
    public function __construct(public string $code, public int $limit, public int $used)
    {
    }

    public static function fromEntity(Code $code): self
    {
        return new self(
            $code->getCode(),
            $code->getLimit(),
            $code->getUsed()
        );
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'limit' => $this->limit,
            'used' => $this->used,
        ];
    }

    public function isUsed(): bool
    {
        return $this->used >= $this->limit;
    }
}
