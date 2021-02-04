<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests\NotNow;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\NotNow\NoRelativeDateTimeInterfaceRule;

/**
 * @covers \SlamPhpStan\NotNow\ForbiddenRelativeFormats
 * @covers \SlamPhpStan\NotNow\NoRelativeDateTimeInterfaceRule
 *
 * @extends RuleTestCase<NoRelativeDateTimeInterfaceRule>
 */
final class NoRelativeDateTimeInterfaceRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoRelativeDateTimeInterfaceRule();
    }

    public function testCases(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/NoRelativeDateTimeInterfaceRule/fixture.php',
            ],
            [
                [
                    'Instantiating DateTimeInterface with relative datetime "now" is forbidden, rely on a clock abstraction like lcobucci/clock',
                    6,
                ],
                [
                    'Instantiating DateTimeInterface without the first argument is forbidden, rely on a clock abstraction like lcobucci/clock',
                    7,
                ],
                [
                    'Instantiating DateTimeInterface with relative datetime "now" is forbidden, rely on a clock abstraction like lcobucci/clock',
                    8,
                ],
                [
                    'Instantiating DateTimeInterface with relative datetime "noon" is forbidden, rely on a clock abstraction like lcobucci/clock',
                    10,
                ],
                [
                    'Instantiating DateTimeInterface with relative datetime "yesterday" is forbidden, rely on a clock abstraction like lcobucci/clock',
                    11,
                ],
                [
                    'Instantiating DateTimeInterface with relative datetime "now" is forbidden, rely on a clock abstraction like lcobucci/clock',
                    16,
                ],
            ]
        );
    }
}
