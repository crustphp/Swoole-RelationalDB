<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2024 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Selector\Enum;

enum BracketOperator: String
{

    case or = 'or';
    case and = 'and';

}