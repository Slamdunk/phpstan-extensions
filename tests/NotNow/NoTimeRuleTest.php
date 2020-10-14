<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests\NotNow;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\NotNow\NoTimeRule;

/**
 * @covers \SlamPhpStan\NotNow\NoTimeRule
 */
final class NoTimeRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoTimeRule($this->createReflectionProvider());
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/NoTimeRule/fixture.php',
            ],
            [
                [
                    'Calling time() directly is forbidden, rely on a clock abstraction like lcobucci/clock',
                    5,
                ],
                [
                    'Calling time() directly is forbidden, rely on a clock abstraction like lcobucci/clock',
                    6,
                ],
            ]
        );
    }
}
