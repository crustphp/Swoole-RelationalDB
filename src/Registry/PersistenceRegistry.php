<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2024 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Registry;

use Crust\SwooleDb\Core\Contract\PersistenceInterface;
use Crust\SwooleDb\Core\Persistence\AsJsonFile;
use Crust\SwooleDb\Exception\NotFoundException;
use Crust\SwooleDb\Exception\SmallSwooleDbException;
use Crust\SwooleDb\Registry\Enum\ParamType;
use Crust\SwooleDb\Registry\Trait\RegistryTrait;

final class PersistenceRegistry
{

    use RegistryTrait;

    const DEFAULT = 'DEFAULT';

    /** @var PersistenceInterface[] */
    private array $persistenceChannels = [
    ];

    private function __construct() {
        $this->persistenceChannels[self::DEFAULT] = new AsJsonFile();
    }

    /**
     * Set default persistence channel
     * @param PersistenceInterface $persistence
     * @return $this
     */
    public function setDefaultChannel(PersistenceInterface $persistence): self
    {
        $this->persistenceChannels[self::DEFAULT] = $persistence;

        return $this;
    }

    /**
     * Set persistence channel $channelName
     * @param string $channelName
     * @param PersistenceInterface $persistence
     * @return $this
     */
    public function setChannel(string $channelName, PersistenceInterface $persistence): self
    {
        $this->persistenceChannels[$channelName] = $persistence;

        return $this;
    }

    /**
     * Get a channel by name
     * @param string $channelName
     * @return PersistenceInterface
     * @throws SmallSwooleDbException
     */
    public function getChannel(string $channelName): PersistenceInterface
    {

        if (!array_key_exists($channelName, $this->persistenceChannels)) {
            throw new NotFoundException('Persistence channel ' . $channelName . ' not defined');
        }

        return $this->persistenceChannels[$channelName];

    }

}