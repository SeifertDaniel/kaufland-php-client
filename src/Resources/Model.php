<?php

namespace ProductFlow\KauflandPhpClient\Resources;

use ProductFlow\KauflandPhpClient\Connection;

class Model
{
    protected Connection $connection;

    protected array $filters = [];

    protected ?int $limit = null;

    protected ?int $offset = null;

    protected array $query = [];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function setOffset(int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function setFilter(string $column, $operation, $value = null)
    {
        if (is_null($value)) {
            $value = $operation;
            $operation = 'eq';
        }

        $this->filters[$column][$operation] = $value;
        return $this;
    }

    public function getQuery(): array
    {
        return array_filter(array_merge(
            $this->query,
            $this->filters,
            [ 'limit' => $this->getLimit(), 'offset' => $this->getOffset() ]
        ));
    }

    public function setQuery($key, $value = null)
    {
        if (is_array($key)) {
            $this->query = $key;
        } else {
            $this->query[$key] = $value;
        }

        return $this;
    }
}
