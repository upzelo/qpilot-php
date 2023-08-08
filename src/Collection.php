<?php

declare(strict_types=1);

namespace Qpilot;

use Traversable;
use Qpilot\ApiOperations\Request;

/**
 * @template TQpilotObject of QpilotObject
 * @template-implements \IteratorAggregate<TQpilotObject>
 *
 * @property bool              $has_more
 * @property ?string           $next_cursor
 * @property ?string           $previous_cursor
 * @property TQpilotObject[] $data
 */
class Collection extends QpilotObject implements \Countable, \IteratorAggregate
{
    use Request;
    public const OBJECT_NAME = 'list';

    protected array $filters = [];

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public static function emptyCollection(): Collection
    {
        return Collection::constructFrom(['data' => []]);
    }

    // public function autoPagingIterator()
    // {
    //     $page = $this;
    //
    //     while (true) {
    //         $filters = $this->filters ?? [];
    //     }
    // }

    public function setFilters(array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    public function all($params = null)
    {
        self::validateParams($params);
    }

    public function nextPage(?array $params = null)
    {
        if ($this->has_more) {
            return static::emptyCollection();
        }

        $lastId = end($this->data)->id;

        $params = array_merge(
            $this->filters ?? [],
            ['cursor' => $this->next_cursor],
            $params ?? [],
        );

        return $this->all();
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->data);
    }
}
