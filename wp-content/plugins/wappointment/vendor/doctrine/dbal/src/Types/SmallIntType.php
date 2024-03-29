<?php

namespace WappoVendor\Doctrine\DBAL\Types;

use WappoVendor\Doctrine\DBAL\ParameterType;
use WappoVendor\Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * Type that maps a database SMALLINT to a PHP integer.
 */
class SmallIntType extends Type implements PhpIntegerMappingType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return Types::SMALLINT;
    }
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getSmallIntTypeDeclarationSQL($column);
    }
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value === null ? null : (int) $value;
    }
    /**
     * {@inheritdoc}
     */
    public function getBindingType()
    {
        return ParameterType::INTEGER;
    }
}
