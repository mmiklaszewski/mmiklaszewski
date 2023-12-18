<?php

namespace App\Domain\ValueObject\AI;

final readonly class OpenAIConfiguration implements \JsonSerializable
{
    public function __construct(
        public Model $model,
        public ResponseFormat $format,
        public float $temperature,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'model' => $this->model->jsonSerialize(),
            'response_format' => ['type' => $this->format->jsonSerialize()],
            'temperature' => $this->temperature,
        ];
    }
}
