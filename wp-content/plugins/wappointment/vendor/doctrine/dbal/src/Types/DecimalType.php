<?php

namespace WappoVendor\Doctrine\DBAL\Types;

use WappoVendor\Doctrine\DBAL\Platforms\AbstractPlatform;
use function is_float;
use function is_int;
use const PHP_VERSION_ID;
/**
 * Type that maps an SQL DECIMAL to a PHP string.
 */
class DecimalType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return Types::DECIMAL;
    }
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getDecimalTypeDeclarationSQL($column);
    }
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        // Some drivers starting from PHP 8.1 can represent decimals as float/int
        // See also: https://github.com/doctrine/dbal/pull/4818
        if (PHP_VERSION_ID >= 80100 && (is_float($value) || is_int($value))) {
            return (string) $value;
        }
        return $value;
    }
}
