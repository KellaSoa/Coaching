<?php

namespace WappoVendor\Doctrine\DBAL\Driver;

use WappoVendor\Doctrine\DBAL\Connection;
use WappoVendor\Doctrine\DBAL\Driver\API\ExceptionConverter;
use WappoVendor\Doctrine\DBAL\Driver\API\PostgreSQL;
use WappoVendor\Doctrine\DBAL\Exception;
use WappoVendor\Doctrine\DBAL\Platforms\AbstractPlatform;
use WappoVendor\Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use WappoVendor\Doctrine\DBAL\Platforms\PostgreSQL94Platform;
use WappoVendor\Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use WappoVendor\Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use WappoVendor\Doctrine\DBAL\VersionAwarePlatformDriver;
use WappoVendor\Doctrine\Deprecations\Deprecation;
use function assert;
use function preg_match;
use function version_compare;
/**
 * Abstract base implementation of the {@see Driver} interface for PostgreSQL based drivers.
 */
abstract class AbstractPostgreSQLDriver implements VersionAwarePlatformDriver
{
    /**
     * {@inheritdoc}
     */
    public function createDatabasePlatformForVersion($version)
    {
        if (preg_match('/^(?P<major>\\d+)(?:\\.(?P<minor>\\d+)(?:\\.(?P<patch>\\d+))?)?/', $version, $versionParts) === 0) {
            throw Exception::invalidPlatformVersionSpecified($version, '<major_version>.<minor_version>.<patch_version>');
        }
        $majorVersion = $versionParts['major'];
        $minorVersion = $versionParts['minor'] ?? 0;
        $patchVersion = $versionParts['patch'] ?? 0;
        $version = $majorVersion . '.' . $minorVersion . '.' . $patchVersion;
        if (version_compare($version, '10.0', '>=')) {
            return new PostgreSQL100Platform();
        }
        Deprecation::trigger('doctrine/dbal', 'https://github.com/doctrine/dbal/pull/5060', 'PostgreSQL 9 support is deprecated and will be removed in DBAL 4.' . ' Consider upgrading to Postgres 10 or later.');
        return new PostgreSQL94Platform();
    }
    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new PostgreSQL94Platform();
    }
    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn, AbstractPlatform $platform)
    {
        assert($platform instanceof PostgreSQLPlatform);
        return new PostgreSQLSchemaManager($conn, $platform);
    }
    public function getExceptionConverter() : ExceptionConverter
    {
        return new PostgreSQL\ExceptionConverter();
    }
}
