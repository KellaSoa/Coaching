<?php

declare (strict_types=1);
namespace WappoVendor\Doctrine\DBAL\Driver\Exception;

use WappoVendor\Doctrine\DBAL\Driver\AbstractException;
use function sprintf;
/**
 * @internal
 *
 * @psalm-immutable
 */
final class UnknownParameterType extends AbstractException
{
    /**
     * @param mixed $type
     */
    public static function new($type) : self
    {
        return new self(sprintf('Unknown parameter type, %d given.', $type));
    }
}
