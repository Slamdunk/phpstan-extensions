<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests\NotNow;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\NotNow\NoDateWithoutSecondArgumentRule;

/**
 * @covers \SlamPhpStan\NotNow\NoDateWithoutSecondArgumentRule
 *
 * @extends RuleTestCase<NoDateWithoutSecondArgumentRule>
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
                    6,
                ],
                [
                    'Calling date() without the second parameter is forbidden, rely on a clock abstraction like lcobucci/clock',
                    7,
                ],
            ]
        );
    }
}
