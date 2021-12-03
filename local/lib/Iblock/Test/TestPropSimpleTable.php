<?php
declare(strict_types=1);

namespace Pwd\Iblock\Test;

use spaceonfire\BitrixTools\ORM\IblockPropSimple;

final class TestPropSimpleTable extends IblockPropSimple
{
    public static function getIblockId(): int
    {
        return TestTable::getIblockId();
    }
}
