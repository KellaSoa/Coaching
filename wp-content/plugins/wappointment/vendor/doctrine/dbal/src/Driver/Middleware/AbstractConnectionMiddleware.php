<?php

namespace WappoVendor\Doctrine\DBAL\Driver\Middleware;

use WappoVendor\Doctrine\DBAL\Driver\Connection;
use WappoVendor\Doctrine\DBAL\Driver\Result;
use WappoVendor\Doctrine\DBAL\Driver\ServerInfoAwareConnection;
use WappoVendor\Doctrine\DBAL\Driver\Statement;
use WappoVendor\Doctrine\DBAL\ParameterType;
use WappoVendor\Doctrine\Deprecations\Deprecation;
use LogicException;
use function get_class;
use function method_exists;
use function sprintf;
abstract class AbstractConnectionMiddleware implements ServerInfoAwareConnection
{
    /** @var Connection */
    private $wrappedConnection;
    public function __construct(Connection $wrappedConnection)
    {
        $this->wrappedConnection = $wrappedConnection;
    }
    public function prepare(string $sql) : Statement
    {
        return $this->wrappedConnection->prepare($sql);
    }
    public function query(string $sql) : Result
    {
        return $this->wrappedConnection->query($sql);
    }
    /**
     * {@inheritdoc}
     */
    public function quote($value, $type = ParameterType::STRING)
    {
        return $this->wrappedConnection->quote($value, $type);
    }
    public function exec(string $sql) : int
    {
        return $this->wrappedConnection->exec($sql);
    }
    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        if ($name !== null) {
            Deprecation::triggerIfCalledFromOutside('doctrine/dbal', 'https://github.com/doctrine/dbal/issues/4687', 'The usage of Connection::lastInsertId() with a sequence name is deprecated.');
        }
        return $this->wrappedConnection->lastInsertId($name);
    }
    /**
     * {@inheritdoc}
     */
    public function beginTransaction()
    {
        return $this->wrappedConnection->beginTransaction();
    }
    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        return $this->wrappedConnection->commit();
    }
    /**
     * {@inheritdoc}
     */
    public function rollBack()
    {
        return $this->wrappedConnection->rollBack();
    }
    /**
     * {@inheritdoc}
     */
    public function getServerVersion()
    {
        if (!$this->wrappedConnection instanceof ServerInfoAwareConnection) {
            throw new LogicException('The underlying connection is not a ServerInfoAwareConnection');
        }
        return $this->wrappedConnection->getServerVersion();
    }
    /**
     * @return resource|object
     */
    public function getNativeConnection()
    {
        if (!method_exists($this->wrappedConnection, 'getNativeConnection')) {
            throw new LogicException(sprintf('The driver connection %s does not support accessing the native connection.', get_class($this->wrappedConnection)));
        }
        return $this->wrappedConnection->getNativeConnection();
    }
}
