<?php
declare(strict_types=1);

namespace Pwd\Iblock\Benefit;

use spaceonfire\BitrixTools\ORM\IblockPropSimple;

final class BenefitPropSimpleTable extends IblockPropSimple
{
    public static function getIblockId(): int
    {
        return BenefitTable::getIblockId();
    }
}
