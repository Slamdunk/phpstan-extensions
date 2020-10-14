<?php

declare(strict_types=1);

namespace SlamPhpStan\NotNow;

final class ForbiddenRelativeFormats
{
    private const FORBIDDEN_VALUES = [
        'yesterday' => true,
        'midnight'  => true,
        'today'     => true,
        'now'       => true,
        'noon'      => true,
        'tomorrow'  => true,
    ];

    public static function isForbidden(string $value): bool
    {
        return isset(self::FORBIDDEN_VALUES[$value]);
    }
}
