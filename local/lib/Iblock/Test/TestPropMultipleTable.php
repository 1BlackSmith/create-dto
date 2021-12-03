<?php
declare(strict_types=1);

namespace Pwd\Iblock\Test;

use spaceonfire\BitrixTools\ORM\IblockPropMultiple;

final class TestPropMultipleTable extends IblockPropMultiple
{
    public static function getIblockId(): int
    {
        return TestTable::getIblockId();
    }
}
