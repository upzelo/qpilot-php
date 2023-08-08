<?php

declare(strict_types=1);

namespace Qpilot\Contracts\HttpClient;

interface ClientInterface
{
    public function request(string $method, string $url, array $headers = [], array $params = []): array;
}
