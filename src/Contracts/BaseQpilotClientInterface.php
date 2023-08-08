<?php

declare(strict_types=1);

namespace Qpilot\Contracts;

interface BaseQpilotClientInterface
{
    public function getApiKey();

    public function getClientId();

    public function getSiteId();

    public function getApiBase();
}
