<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2024 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Core\Bean;

use Crust\SwooleDb\Core\Enum\Operator;

final readonly class IndexFilter
{

    public function __construct(
        public Operator $operator,
        public string $field,
        public string|int|float|null $value,
    ) {}

}