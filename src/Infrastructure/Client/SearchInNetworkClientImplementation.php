<?php

namespace App\Infrastructure\Client;

use App\Domain\Client\SearchInNetworkClient;
use App\Domain\Exception\SearchInNetworkException;
use App\Domain\ValueObject\NetworkResult;
use GuzzleHttp\Client;

final readonly class SearchInNetworkClientImplementation implements SearchInNetworkClient
{
    public function __construct(private string $serperToken)
    {
    }

    #[\Override]
    public function search(string $query): NetworkResult
    {
        try {
            $client = new Client();
            $headers = [
                'X-API-KEY' => $this->serperToken,
                'Content-Type' => 'application/json; charset=UTF-8',
            ];

            $body = [
                'q' => $query,
                'gl' => 'pl',
                'hl' => 'pl',
            ];

            $responseAnswer = $client->request('POST', 'https://google.serper.dev/search', [
                'headers' => $headers,
                'body' => json_encode($body),
            ]);

            $data = json_decode($responseAnswer->getBody()->getContents(), true);
        } catch (\Throwable $exception) {
            throw SearchInNetworkException::create($exception->getMessage());
        }

        if (!is_array($data)) {
            throw SearchInNetworkException::create('Incorrect data');
        }

        return new NetworkResult($data);
    }
}
