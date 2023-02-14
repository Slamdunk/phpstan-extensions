<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests\NotNow;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use SlamPhpStan\NotNow\ForbiddenRelativeFormats;
use SlamPhpStan\NotNow\NoRelativeStrtotimeRule;

/**
 * @extends RuleTestCase<NoRelativeStrtotimeRule>
 */
#[CoversClass(ForbiddenRelativeFormats::class)]
#[CoversClass(NoRelativeStrtotimeRule::class)]
final class NoRelativeStrtotimeRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoRelativeStrtotimeRule($this->createReflectionProvider());
    }

    public function testCases(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/NoRelativeStrtotimeRule/fixture.php',
            ],
            [
                [
                    'Calling strtotime() with relative datetime "now" without the second argument is forbidden, rely on a clock abstraction like lcobucci/clock',
                    6,
                ],
                [
                    'Calling strtotime() with relative datetime "noon" without the second argument is forbidden, rely on a clock abstraction like lcobucci/clock',
                    7,
                ],
                [
                    'Calling strtotime() with relative datetime "now" without the second argument is forbidden, rely on a clock abstraction like lcobucci/clock',
                    12,
                ],
            ]
        );
    }
}
