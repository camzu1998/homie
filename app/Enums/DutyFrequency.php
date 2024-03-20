<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static DAILY()
 * @method static WEEKLY()
 * @method static MONTHLY()
 * @method static YEARLY()
 */
final class DutyFrequency extends Enum
{
    const DAILY = 1;
    const WEEKLY = 7;
    const MONTHLY = 30;
    const YEARLY = 365;
}
