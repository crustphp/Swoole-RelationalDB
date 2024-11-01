<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2024 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Selector\Bean;

use Small\Collection\Collection\Collection;
use Small\Collection\Contract\CheckValueInterface;
use Crust\SwooleDb\Core\RecordCollection;
use Crust\SwooleDb\Selector\Exception\SyntaxErrorException;

/**
 * @method OrderByField offsetGet(mixed $offset)
 * @method OrderByField current()
 */
class OrderByCollection extends Collection
    implements CheckValueInterface
{
    #[\Override] public function checkValue(mixed $value): CheckValueInterface
    {

        if (!$value instanceof OrderByField) {
            throw new SyntaxErrorException(self::class . ' accept only ' . OrderByField::class);
        }

        return $this;

    }

}