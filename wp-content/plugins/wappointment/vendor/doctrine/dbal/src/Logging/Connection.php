<?php

declare (strict_types=1);
namespace WappoVendor\Doctrine\DBAL\Logging;

use WappoVendor\Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use WappoVendor\Doctrine\DBAL\Driver\Middleware\AbstractConnectionMiddleware;
use WappoVendor\Doctrine\DBAL\Driver\Result;
use WappoVendor\Doctrine\DBAL\Driver\Statement as DriverStatement;
use WappoVendor\Psr\Log\LoggerInterface;
final class Connection extends AbstractConnectionMiddleware
{
    /** @var LoggerInterface */
    private $logger;
    /**
     * @internal This connection can be only instantiated by its driver.
     */
    public function __construct(ConnectionInterface $connection, LoggerInterface $logger)
    {
        parent::__construct($connection);
        $this->logger = $logger;
    }
    public function __destruct()
    {
        $this->logger->info('Disconnecting');
    }
    public function prepare(string $sql) : DriverStatement
    {
        return new Statement(parent::prepare($sql), $this->logger, $sql);
    }
    public function query(string $sql) : Result
    {
        $this->logger->debug('Executing query: {sql}', ['sql' => $sql]);
        return parent::query($sql);
    }
    public function exec(string $sql) : int
    {
        $this->logger->debug('Executing statement: {sql}', ['sql' => $sql]);
        return parent::exec($sql);
    }
    /**
     * {@inheritDoc}
     */
    public function beginTransaction()
    {
        $this->logger->debug('Beginning transaction');
        return parent::beginTransaction();
    }
    /**
     * {@inheritDoc}
     */
    public function commit()
    {
        $this->logger->debug('Committing transaction');
        return parent::commit();
    }
    /**
     * {@inheritDoc}
     */
    public function rollBack()
    {
        $this->logger->debug('Rolling back transaction');
        return parent::rollBack();
    }
}
