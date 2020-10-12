<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\NoDateWithoutSecondArgumentRule;

/**
 * @covers \SlamPhpStan\NoDateWithoutSecondArgumentRule
 */
final class NoDateWithoutSecondArgumentRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoDateWithoutSecondArgumentRule($this->createReflectionProvider());
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/NoDateWithoutSecondArgumentRule/fixture.php',
            ],
            [
                [
                    'Calling date() without the second parameter is forbidden, rely on a clock abstraction like lcobucci/clock',
                    5,
                ],
                [
                    'Calling date() without the second parameter is forbidden, rely on a clock abstraction like lcobucci/clock',
                    6,
                ],
            ]
        );
    }
}
