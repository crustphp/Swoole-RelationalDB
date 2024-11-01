<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2023 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Test\Registry;

use \PHPUnit\Framework\TestCase;
use Crust\SwooleDb\Core\Column;
use Crust\SwooleDb\Core\Enum\ColumnType;
use Crust\SwooleDb\Core\Persistence\AsJsonFile;
use Crust\SwooleDb\Core\Table;
use Crust\SwooleDb\Exception\FileNotFoundException;
use Crust\SwooleDb\Exception\TableAlreadyExists;
use Crust\SwooleDb\Exception\TableNotExists;
use Crust\SwooleDb\Registry\Enum\ParamType;
use Crust\SwooleDb\Registry\ParamRegistry;
use Crust\SwooleDb\Registry\PersistenceRegistry;
use Crust\SwooleDb\Registry\TableRegistry;

class TableRegistryTest extends TestCase
{

    public function testTableCreation()
    {

        TableRegistry::getInstance()->createTable('test', 125);

        self::assertInstanceOf(Table::class, TableRegistry::getInstance()->getTable('test'));

        try {
            TableRegistry::getInstance()->createTable('test', 52);
        } catch (\Exception $e) {}

        self::assertInstanceOf(TableAlreadyExists::class, $e);

    }

    public function testTableNotExists()
    {

        try {
            TableRegistry::getInstance()->getTable('fake');
        } catch (\Exception $e) {}

        self::assertInstanceOf(TableNotExists::class, $e);

        try {
            TableRegistry::getInstance()->destroy('fake');
        } catch (\Exception $e) {}

        self::assertInstanceOf(TableNotExists::class, $e);

    }

    public function testPersistence()
    {

        ParamRegistry::getInstance()->set(ParamType::varLibDir, '');
        ParamRegistry::getInstance()->set(ParamType::dataDirName, 'tmp');

        $table = TableRegistry::getInstance()->createTable('testPersist', 125);
        $table->addColumn(
            new Column('test', ColumnType::string, 256),
        );
        $table->create();

        TableRegistry::getInstance()->persist('testPersist');

        /** @var AsJsonFile $asJsonFile */
        $asJsonFile = PersistenceRegistry::getInstance()->getChannel(PersistenceRegistry::DEFAULT);

        $filename = $asJsonFile->getFilename('testPersist');

        $content = file_get_contents($filename);

        self::assertEquals(
            '{"name":"testPersist","columns":[{"name":"test","type":3,"size":256}],"rowMaxSize":125,"data":[]}',
            $content);

        TableRegistry::getInstance()->destroy('testPersist');

        TableRegistry::getInstance()->load('testPersist');

        self::assertInstanceOf(Table::class, TableRegistry::getInstance()
            ->load('testPersist')
        );

        try {
            TableRegistry::getInstance()->persist('fake');
        } catch (\Exception $e) {}

        self::assertInstanceOf(TableNotExists::class, $e);

        try {
            TableRegistry::getInstance()->load('fake');
        } catch (\Exception $e) {}

        self::assertInstanceOf(FileNotFoundException::class, $e);

    }

}