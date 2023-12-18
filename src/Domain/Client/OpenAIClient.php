<?php

namespace App\Domain\Client;

use App\Domain\Collection\AI\Messages;
use App\Domain\ValueObject\AI\OpenAIConfiguration;

interface OpenAIClient
{
    public function request(OpenAIConfiguration $configuration, Messages $messages): string;
}
