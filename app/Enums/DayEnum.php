<?php

namespace App\Enums;

enum DayEnum: int
{
    const SUNDAY = 1;
    const MONDAY = 2;
    const TUESDAY = 3;
    const WEDNESDAY = 4;
    const THURSDAY = 5;
    const FRIDAY = 6;
    const SATURDAY = 7;

    public function getName(): string
    {
        return match ($this) {
            self::SUNDAY => 'Sunday',
            self::MONDAY => 'Monday',
            self::TUESDAY => 'Tuesday',
            self::WEDNESDAY => 'Wednesday',
            self::THURSDAY => 'Thursday',
            self::FRIDAY => 'Friday',
            self::SATURDAY => 'Saturday',
        };
    }

    public static function getValues(): array
    {
        return [
            self::SUNDAY,
            self::MONDAY,
            self::TUESDAY,
            self::WEDNESDAY,
            self::THURSDAY,
            self::FRIDAY,
            self::SATURDAY,
        ];
    }
}