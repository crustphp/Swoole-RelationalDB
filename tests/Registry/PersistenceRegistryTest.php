<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2023 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Test\Registry;

use PHPUnit\Framework\TestCase;
use Crust\SwooleDb\Core\Persistence\AsJsonFile;
use Crust\SwooleDb\Exception\NotFoundException;
use Crust\SwooleDb\Registry\Enum\ParamType;
use Crust\SwooleDb\Registry\ParamRegistry;
use Crust\SwooleDb\Registry\PersistenceRegistry;

class PersistenceRegistryTest extends TestCase
{

    public function testSetters()
    {

        ParamRegistry::getInstance()->set(ParamType::varLibDir, '');
        ParamRegistry::getInstance()->set(ParamType::dataDirName, 'tmp');

        PersistenceRegistry::getInstance()->setDefaultChannel(
            new AsJsonFile(),
        );

        /** @var AsJsonFile $channel */
        $channel = PersistenceRegistry::getInstance()->getChannel(PersistenceRegistry::DEFAULT);

        self::assertEquals($channel->getDataDirname(), '/tmp');

        ParamRegistry::getInstance()->set(ParamType::varLibDir, '');
        ParamRegistry::getInstance()->set(ParamType::dataDirName, 'tmp');

        PersistenceRegistry::getInstance()->setChannel(
            'test',
            new AsJsonFile()
        );

        $channel = PersistenceRegistry::getInstance()->getChannel('test');

        self::assertEquals($channel->getDataDirname(), '/tmp');

    }

    public function testExceptions()
    {

        try {
            PersistenceRegistry::getInstance()->getChannel('testFail');
        } catch (\Exception $e) {}

        self::assertInstanceOf(NotFoundException::class, $e);

    }

}