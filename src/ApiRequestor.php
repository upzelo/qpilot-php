<?php

declare(strict_types=1);

namespace Qpilot;

use GuzzleHttp\Client;

class ApiRequestor
{
    private static ?Client $httpClient = null;

    public function __construct(private string $apiKey, private string $apiBase, private array $config)
    {
    }

    public function request($method, $url, $params = null, $headers = null)
    {
        $params = $params ?: [];
        $headers = $headers ?: [];

        self::$httpClient = new Client([
            'base_uri' => $this->apiBase,
            'headers' => [
                'Authorization' => 'qpilot-apikey ' . $this->config['site_id'] . ";" . $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Qpilot-Version' => $this->config['Qpilot_version'],
                ...$headers,
            ],
        ]);

        $response = match ($method) {
            'post' => $this->httpClient()->post($url, ['json' => $params]),
            'put' => $this->httpClient()->put($url, ['json' => $params]),
            'delete' => $this->httpClient()->delete($url, ['json' => $params]),
            default => $this->httpClient()->get($url, ['query' => $params]),
        };

        $body = $response->getBody()->getContents();

        return new ApiResponse(
            $response->getHeaders(),
            $body,
            json_decode($body, true) ?? [],
            $response->getStatusCode()
        );
    }

    private function httpClient(): Client
    {
        if (!self::$httpClient) {
            self::$httpClient = new Client([
                'base_uri' => $this->apiBase,
                'headers' => [
                    'Authorization' => 'qpilot-apikey ' . $this->config['site_id'] . ";" . $this->apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Qpilot-Version' => $this->config['Qpilot_version'],
                ],
            ]);
        }

        return self::$httpClient;
    }
}
