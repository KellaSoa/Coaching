<?php

namespace WappoVendor\Doctrine\DBAL\Cache;

use WappoVendor\Doctrine\DBAL\Driver\FetchUtils;
use WappoVendor\Doctrine\DBAL\Driver\Result;
use function array_values;
use function count;
use function reset;
/**
 * @internal The class is internal to the caching layer implementation.
 */
final class ArrayResult implements Result
{
    /** @var list<array<string, mixed>> */
    private $data;
    /** @var int */
    private $columnCount = 0;
    /** @var int */
    private $num = 0;
    /**
     * @param list<array<string, mixed>> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        if (count($data) === 0) {
            return;
        }
        $this->columnCount = count($data[0]);
    }
    /**
     * {@inheritdoc}
     */
    public function fetchNumeric()
    {
        $row = $this->fetch();
        if ($row === \false) {
            return \false;
        }
        return array_values($row);
    }
    /**
     * {@inheritdoc}
     */
    public function fetchAssociative()
    {
        return $this->fetch();
    }
    /**
     * {@inheritdoc}
     */
    public function fetchOne()
    {
        $row = $this->fetch();
        if ($row === \false) {
            return \false;
        }
        return reset($row);
    }
    /**
     * {@inheritdoc}
     */
    public function fetchAllNumeric() : array
    {
        return FetchUtils::fetchAllNumeric($this);
    }
    /**
     * {@inheritdoc}
     */
    public function fetchAllAssociative() : array
    {
        return FetchUtils::fetchAllAssociative($this);
    }
    /**
     * {@inheritdoc}
     */
    public function fetchFirstColumn() : array
    {
        return FetchUtils::fetchFirstColumn($this);
    }
    public function rowCount() : int
    {
        return count($this->data);
    }
    public function columnCount() : int
    {
        return $this->columnCount;
    }
    public function free() : void
    {
        $this->data = [];
    }
    /**
     * @return array<string, mixed>|false
     */
    private function fetch()
    {
        if (!isset($this->data[$this->num])) {
            return \false;
        }
        return $this->data[$this->num++];
    }
}
