<?php

declare(strict_types=1);

namespace Qpilot\Services;

use Qpilot\Contracts\QpilotClientInterface;
use Qpilot\Exceptions\InvalidArgumentException;

use function trim;
use function sprintf;
use function array_map;

abstract class AbstractService
{
    public function __construct(protected QpilotClientInterface $client)
    {
    }

    public function getClient(): QpilotClientInterface
    {
        return $this->client;
    }

    protected function request($method, $path, $params, $objectType, $isList = false)
    {
        return $this->getClient()->request($method, $path, $params, $objectType, $isList);
    }

    protected function requestCollection($method, $path, $params, string $objectType)
    {
        return $this->getClient()->requestCollection($method, $path, $params, $objectType);
    }

    protected function buildPath(string $basepath, ...$ids): string
    {
        foreach ($ids as $id) {
            if (null === $id || (\is_string($id) && '' === trim($id))) {
                throw new InvalidArgumentException('Resource ID\'s cannot be null or whitespace');
            }
        }

        return sprintf($basepath, ...array_map('urlencode', $ids));
    }
}
