<?php

declare (strict_types=1);
namespace WappoVendor\Doctrine\DBAL\Platforms\MySQL;

/**
 * @internal
 */
interface CollationMetadataProvider
{
    public function getCollationCharset(string $collation) : ?string;
}
