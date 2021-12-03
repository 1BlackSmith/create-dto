<?php
declare(strict_types=1);

namespace Pwd\Iblock\Test;

use spaceonfire\BitrixTools\ORM\IblockSection;

final class TestSectionTable extends IblockSection
{
    public static function getIblockId(): int
    {
        return TestTable::getIblockId();
    }
}
