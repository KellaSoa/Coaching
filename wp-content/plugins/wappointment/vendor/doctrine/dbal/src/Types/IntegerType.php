<?php

namespace WappoVendor\Doctrine\DBAL\Types;

use WappoVendor\Doctrine\DBAL\ParameterType;
use WappoVendor\Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * Type that maps an SQL INT to a PHP integer.
 */
class IntegerType extends Type implements PhpIntegerMappingType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return Types::INTEGER;
    }
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
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
