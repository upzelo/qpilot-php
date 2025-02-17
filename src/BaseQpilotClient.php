<?php

declare(strict_types=1);

namespace Qpilot;

use Qpilot\Helpers\Util;
use Qpilot\Contracts\QpilotClientInterface;
use Qpilot\Exceptions\InvalidArgumentException;

use function is_string;
use function preg_match;
use function array_merge;

class BaseQpilotClient implements QpilotClientInterface
{
    /**
     * @var array<string, string|QpilotEnum::DEFAULT_API_VERSION|QpilotEnum::DEFAULT_API_BASE|null>
     */
    private array $config;

    /**
     * @param array<string, string>|string $config
     */
    public function __construct(array|string $config = [])
    {
        if (is_string($config)) {
            $config = ['api_key' => $config];
        }

        $config = array_merge($this->getDefaultConfig(), $config);
        $this->validateConfig($config);

        $this->config = $config;
    }

    public function getApiKey(): mixed
    {
        return $this->config['api_key'];
    }

    public function getClientId(): mixed
    {
        return $this->config['client_id'];
    }

    public function getSiteId(): mixed
    {
        return $this->config['site_id'];
    }

    public function getApiBase(): ?string
    {
        return $this->config['api_base'];
    }

    public function request($method, $path, $params, string $objectType, bool $isList = false)
    {
        $baseUrl = $this->getApiBase();
        $path = "Sites/" . $this->getSiteId() . $path;
        $requestor = new ApiRequestor($this->getApiKey(), $baseUrl, $this->config);

        $response = $requestor->request($method, $path, $params);

        // Fix the api response to make live easier for processing.
        $fixedResponse = $this->formatApiResponse($response->json, $objectType, $isList);

        $obj = Util::convertToQpilotObject($fixedResponse);
        $obj->setLastResponse($response);

        return $obj;
    }

    public function formatApiResponse(array $response, string $type, bool $isList): array
    {
        // Set the type of data we are working with...

        $resp = [];

        // If it's a list, we need to specify that it's a list object.
        $resp['object'] = $isList ? 'list' : $type;

        if (!$isList) {
            $data = $response['item'] ?? $response ?? [];

            return [...$data, ...$resp];
        }

        $resp['has_more'] = (bool) ($response['next_cursor'] ?? false);
        $resp['previous_cursor'] = $response['previous_cursor'] ?? null;
        $resp['next_cursor'] = $response['next_cursor'] ?? null;

        // @TODO: add some handling here for pluralising some words...

        $data = array_map(function ($item) use ($type) {

            $item['object'] = $type;

            return $item;
        }, $response['items']);

        $resp['data'] = $data;

        return $resp;
    }

    public function requestCollection($method, $path, $params, $objectType)
    {
        $object = $this->request($method, $path, $params, $objectType, true);

        if (!($object instanceof Collection)) {
            $expected = Collection::class;
            $receivedClass = \get_class($object);

            throw new InvalidArgumentException("Expected a {$expected}, but received a {$receivedClass}");
        }

        return $object;
    }

    /**
     * @return array<string, string|null>
     */
    private function getDefaultConfig(): array
    {
        return [
            'api_key' => null,
            'client_id' => null,
            'site_id' => null,
            'Qpilot_version' => QpilotEnum::DEFAULT_API_VERSION->value,
            'api_base' => QpilotEnum::DEFAULT_API_BASE->value,
        ];
    }

    /**
     * @param array<string, string|QpilotEnum::DEFAULT_API_VERSION|QpilotEnum::DEFAULT_API_BASE|null> $config
     */
    private function validateConfig(array $config): void
    {
        // Check api_key
        if (null !== $config['api_key']) {
            if (!is_string($config['api_key'])) {
                throw new InvalidArgumentException('The api_key must be a string.');
            }

            if ('' === $config['api_key']) {
                throw new InvalidArgumentException('The api_key must not be empty.');
            }

            if (preg_match('/\s/', $config['api_key'])) {
                throw new InvalidArgumentException('The api_key must not contain whitespace.');
            }
        }

        // check client_id / site id
        if (null !== $config['client_id'] && !\is_string($config['client_id'])) {
            throw new InvalidArgumentException('client_id must be null or a string');
        }
    }
}
