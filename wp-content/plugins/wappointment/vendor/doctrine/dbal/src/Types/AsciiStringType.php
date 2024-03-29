<?php

declare (strict_types=1);
namespace WappoVendor\Doctrine\DBAL\Types;

use WappoVendor\Doctrine\DBAL\ParameterType;
use WappoVendor\Doctrine\DBAL\Platforms\AbstractPlatform;
final class AsciiStringType extends StringType
{
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform) : string
    {
        return $platform->getAsciiStringTypeDeclarationSQL($column);
    }
    public function getBindingType() : int
    {
        return ParameterType::ASCII;
    }
    public function getName() : string
    {
        return Types::ASCII_STRING;
    }
}
