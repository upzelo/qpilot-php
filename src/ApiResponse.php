<?php

declare(strict_types=1);

namespace Qpilot;

class ApiResponse
{
    public function __construct(
        public array $headers,
        public string $body,
        public array $json,
        public int $status,
    ) {
    }
}
