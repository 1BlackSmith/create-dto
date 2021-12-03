<?php
declare(strict_types=1);

namespace Pwd\Iblock\Test;

use spaceonfire\BitrixTools\ORM\IblockElement;

final class TestTable extends IblockElement
{
    public static function getIblockCode(): string
    {
        return 'test';
    }
}
