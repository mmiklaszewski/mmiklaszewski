<?php

namespace App\Infrastructure\Client;

use App\Domain\Client\OpenAIClient;
use App\Domain\Collection\AI\Messages;
use App\Domain\ValueObject\AI\OpenAIConfiguration;

final readonly class OpenAIClientImplementation implements OpenAIClient
{
    public function __construct(private string $openAiToken)
    {
    }

    #[\Override]
    public function request(OpenAIConfiguration $configuration, Messages $messages): string
    {
        $client = \OpenAI::client($this->openAiToken);

        $config = $configuration->jsonSerialize();
        $config['messages'] = $messages->jsonSerialize();

        $response = $client->chat()->create($config);

        return $response->choices[0]->message->content;
    }
}
