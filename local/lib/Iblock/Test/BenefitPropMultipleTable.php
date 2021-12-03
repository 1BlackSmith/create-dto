<?php
declare(strict_types=1);

namespace Pwd\Iblock\Benefit;

use spaceonfire\BitrixTools\ORM\IblockPropMultiple;

final class BenefitPropMultipleTable extends IblockPropMultiple
{
    public static function getIblockId(): int
    {
        return BenefitTable::getIblockId();
    }
}
