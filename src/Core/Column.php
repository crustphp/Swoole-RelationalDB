<?php
/*
 *  This file is a part of small-swoole-db
 *  Copyright 2024 - Sébastien Kus
 *  Under GNU GPL V3 licence
 */

namespace Crust\SwooleDb\Core;

use Crust\SwooleDb\Core\Enum\ColumnType;
use Crust\SwooleDb\Exception\MalformedTable;

class Column
{

    const KEY_COL_NAME = '_key';

    const MAX_FIELD_NAME_SIZE = 256;

    const FORBIDDEN_NAMES = [
        self::KEY_COL_NAME,
    ];

    public function __construct(
        protected readonly string $name,
        protected readonly ColumnType $type,
        protected readonly int $size = 0,
        protected readonly mixed $nullValue = -1,
        protected readonly bool $isNullable = false,
        protected readonly bool $isSigned = false,
    )
    {

        if (strlen($this->name) > self::MAX_FIELD_NAME_SIZE) {
            throw new MalformedTable('The column name \'' . $this->name . '\' exceed max chars lenght for field name (' . self::MAX_FIELD_NAME_SIZE . ' chars)');
        }

        if (in_array($this->name, static::FORBIDDEN_NAMES)) {
            throw new MalformedTable('The column name \'' . $this->name . '\' is forbidden');
        }

        if ($this->type != ColumnType::float && $this->size === 0) {
            throw new MalformedTable('Missing size param for ' . $this->type->name . ' type, creating ' . $name . ' column');
        }

        // If Column is string that it cannot have $isSigned as true
        if ($this->type == ColumnType::string && $this->isSigned) {
            throw new MalformedTable('String column (' . $name . ') cannot be signed');
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ColumnType
     */
    public function getType(): ColumnType
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getSize(): int|null
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getNullValue(): mixed
    {

        return $this->nullValue;

    }
    
    /**
     * Whether the column is nullable or not, nullable columns will have meta ::null as extra column
     *
     * @return bool
     */
    public function isNullable(): bool {
        return $this->isNullable;
    }
    
    /**
     * Whether the column is Signed Column, 
     *
     * @return bool
     */
    public function isSigned(): bool {
        return $this->isSigned;
    }
}