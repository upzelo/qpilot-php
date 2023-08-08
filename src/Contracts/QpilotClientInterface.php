<?php

declare(strict_types=1);

namespace Qpilot\Contracts;

interface QpilotClientInterface extends BaseQpilotClientInterface
{
    public function request($method, $path, $params, string $objectType, bool $isList = false);
}
