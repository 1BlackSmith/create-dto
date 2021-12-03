<?php
declare(strict_types=1);

namespace Pwd\Iblock\Benefit;

use spaceonfire\BitrixTools\ORM\IblockSection;

final class BenefitSectionTable extends IblockSection
{
    public static function getIblockId(): int
    {
        return BenefitTable::getIblockId();
    }
}
