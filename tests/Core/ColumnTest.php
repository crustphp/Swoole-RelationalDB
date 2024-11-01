<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2023 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Test\Core;

use PHPUnit\Framework\TestCase;
use Crust\SwooleDb\Core\Column;
use Crust\SwooleDb\Core\Enum\ColumnType;
use Crust\SwooleDb\Exception\MalformedTable;

class ColumnTest extends TestCase
{

    public function testConstructor()
    {

        $column = new Column('test', ColumnType::string, 36);

        self::assertEquals('test', $column->getName());
        self::assertEquals(ColumnType::string, $column->getType());
        self::assertEquals(36, $column->getSize());

    }

    public function testExceptions()
    {

        try {
            new Column(Column::KEY_COL_NAME, ColumnType::string, 36);
        } catch(\Exception $e) {}

        self::assertInstanceOf(MalformedTable::class, $e);

        unset($e);
        try {
            new Column('test', ColumnType::string, 0);
        } catch (\Exception $e) {}

        self::assertInstanceOf(MalformedTable::class, $e);

    }

}