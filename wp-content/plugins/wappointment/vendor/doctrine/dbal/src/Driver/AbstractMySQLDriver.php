<?php

namespace WappoVendor\Doctrine\DBAL\Driver;

use WappoVendor\Doctrine\DBAL\Connection;
use WappoVendor\Doctrine\DBAL\Driver\API\ExceptionConverter;
use WappoVendor\Doctrine\DBAL\Driver\API\MySQL;
use WappoVendor\Doctrine\DBAL\Exception;
use WappoVendor\Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use WappoVendor\Doctrine\DBAL\Platforms\AbstractPlatform;
use WappoVendor\Doctrine\DBAL\Platforms\MariaDb1027Platform;
use WappoVendor\Doctrine\DBAL\Platforms\MySQL57Platform;
use WappoVendor\Doctrine\DBAL\Platforms\MySQL80Platform;
use WappoVendor\Doctrine\DBAL\Platforms\MySQLPlatform;
use WappoVendor\Doctrine\DBAL\Schema\MySQLSchemaManager;
use WappoVendor\Doctrine\DBAL\VersionAwarePlatformDriver;
use WappoVendor\Doctrine\Deprecations\Deprecation;
use function assert;
use function preg_match;
use function stripos;
use function version_compare;
/**
 * Abstract base implementation of the {@see Driver} interface for MySQL based drivers.
 */
abstract class AbstractMySQLDriver implements VersionAwarePlatformDriver
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function createDatabasePlatformForVersion($version)
    {
        $mariadb = stripos($version, 'mariadb') !== \false;
        if ($mariadb && version_compare($this->getMariaDbMysqlVersionNumber($version), '10.2.7', '>=')) {
            return new MariaDb1027Platform();
        }
        if (!$mariadb) {
            $oracleMysqlVersion = $this->getOracleMysqlVersionNumber($version);
            if (version_compare($oracleMysqlVersion, '8', '>=')) {
                return new MySQL80Platform();
            }
            if (version_compare($oracleMysqlVersion, '5.7.9', '>=')) {
                return new MySQL57Platform();
            }
        }
        Deprecation::trigger('doctrine/dbal', 'https://github.com/doctrine/dbal/pull/5060', 'MySQL 5.6 support is deprecated and will be removed in DBAL 4.' . ' Consider upgrading to MySQL 5.7 or later.');
        return $this->getDatabasePlatform();
    }
    /**
     * Get a normalized 'version number' from the server string
     * returned by Oracle MySQL servers.
     *
     * @param string $versionString Version string returned by the driver, i.e. '5.7.10'
     *
     * @throws Exception
     */
    private function getOracleMysqlVersionNumber(string $versionString) : string
    {
        if (preg_match('/^(?P<major>\\d+)(?:\\.(?P<minor>\\d+)(?:\\.(?P<patch>\\d+))?)?/', $versionString, $versionParts) === 0) {
            throw Exception::invalidPlatformVersionSpecified($versionString, '<major_version>.<minor_version>.<patch_version>');
        }
        $majorVersion = $versionParts['major'];
        $minorVersion = $versionParts['minor'] ?? 0;
        $patchVersion = $versionParts['patch'] ?? null;
        if ($majorVersion === '5' && $minorVersion === '7' && $patchVersion === null) {
            $patchVersion = '9';
        }
        return $majorVersion . '.' . $minorVersion . '.' . $patchVersion;
    }
    /**
     * Detect MariaDB server version, including hack for some mariadb distributions
     * that starts with the prefix '5.5.5-'
     *
     * @param string $versionString Version string as returned by mariadb server, i.e. '5.5.5-Mariadb-10.0.8-xenial'
     *
     * @throws Exception
     */
    private function getMariaDbMysqlVersionNumber(string $versionString) : string
    {
        if (preg_match('/^(?:5\\.5\\.5-)?(mariadb-)?(?P<major>\\d+)\\.(?P<minor>\\d+)\\.(?P<patch>\\d+)/i', $versionString, $versionParts) === 0) {
            throw Exception::invalidPlatformVersionSpecified($versionString, '^(?:5\\.5\\.5-)?(mariadb-)?<major_version>.<minor_version>.<patch_version>');
        }
        return $versionParts['major'] . '.' . $versionParts['minor'] . '.' . $versionParts['patch'];
    }
    /**
     * {@inheritdoc}
     *
     * @return AbstractMySQLPlatform
     */
    public function getDatabasePlatform()
    {
        return new MySQLPlatform();
    }
    /**
     * {@inheritdoc}
     *
     * @return MySQLSchemaManager
     */
    public function getSchemaManager(Connection $conn, AbstractPlatform $platform)
    {
        assert($platform instanceof AbstractMySQLPlatform);
        return new MySQLSchemaManager($conn, $platform);
    }
    public function getExceptionConverter() : ExceptionConverter
    {
        return new MySQL\ExceptionConverter();
    }
}
