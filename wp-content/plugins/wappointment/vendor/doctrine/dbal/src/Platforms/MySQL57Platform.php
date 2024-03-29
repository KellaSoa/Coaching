<?php

namespace WappoVendor\Doctrine\DBAL\Platforms;

use WappoVendor\Doctrine\DBAL\Schema\Index;
use WappoVendor\Doctrine\DBAL\Schema\TableDiff;
use WappoVendor\Doctrine\DBAL\SQL\Parser;
use WappoVendor\Doctrine\DBAL\Types\Types;
use WappoVendor\Doctrine\Deprecations\Deprecation;
/**
 * Provides the behavior, features and SQL dialect of the MySQL 5.7 (5.7.9 GA) database platform.
 *
 * @deprecated This class will be merged with {@see MySQLPlatform} in 4.0 because support for MySQL
 *             releases prior to 5.7 will be dropped.
 */
class MySQL57Platform extends MySQLPlatform
{
    /**
     * {@inheritdoc}
     */
    public function hasNativeJsonType()
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     */
    public function getJsonTypeDeclarationSQL(array $column)
    {
        return 'JSON';
    }
    public function createSQLParser() : Parser
    {
        return new Parser(\true);
    }
    /**
     * {@inheritdoc}
     */
    protected function getPreAlterTableRenameIndexForeignKeySQL(TableDiff $diff)
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    protected function getPostAlterTableRenameIndexForeignKeySQL(TableDiff $diff)
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    protected function getRenameIndexSQL($oldIndexName, Index $index, $tableName)
    {
        return ['ALTER TABLE ' . $tableName . ' RENAME INDEX ' . $oldIndexName . ' TO ' . $index->getQuotedName($this)];
    }
    /**
     * {@inheritdoc}
     *
     * @deprecated Implement {@see createReservedKeywordsList()} instead.
     */
    protected function getReservedKeywordsClass()
    {
        Deprecation::triggerIfCalledFromOutside('doctrine/dbal', 'https://github.com/doctrine/dbal/issues/4510', 'MySQL57Platform::getReservedKeywordsClass() is deprecated,' . ' use MySQL57Platform::createReservedKeywordsList() instead.');
        return Keywords\MySQL57Keywords::class;
    }
    /**
     * {@inheritdoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        parent::initializeDoctrineTypeMappings();
        $this->doctrineTypeMapping['json'] = Types::JSON;
    }
}
