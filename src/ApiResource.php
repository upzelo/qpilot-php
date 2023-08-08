<?php

declare(strict_types=1);

namespace Qpilot;

class ApiResource extends QpilotObject
{
    public function __set($key, $value): void
    {
        parent::__set($key, $value);
    }
}
