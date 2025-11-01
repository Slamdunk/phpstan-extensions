<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests\NotNow;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use SlamPhpStan\NotNow\NoTimeRule;

/**
 * @extends RuleTestCase<NoTimeRule>
 */
#[CoversClass(NoTimeRule::class)]
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
                    6,
                ],
                [
                    'Calling time() directly is forbidden, rely on a clock abstraction like lcobucci/clock',
                    7,
                ],
                [
                    'Calling microtime() directly is forbidden, rely on a clock abstraction like lcobucci/clock',
                    17,
                ],
                [
                    'Calling microtime() directly is forbidden, rely on a clock abstraction like lcobucci/clock',
                    18,
                ],
            ]
        );
    }
}
