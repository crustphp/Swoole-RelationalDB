<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2024 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Core\Enum;

use Crust\SwooleDb\Exception\NotFoundException;

enum Operator
{

    case equal;
    case superior;
    case superiorOrEqual;
    case inferior;
    case inferiorOrEqual;

    public static function findByName(string $name): self
    {

        foreach (self::cases() as $operator) {
            if ($operator->name == $name) {
                return $operator;
            }
        }

        throw new NotFoundException('Operator ' . $name . ' not found');

    }

}