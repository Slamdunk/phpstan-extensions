<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhp;
use SlamPhpStan\UnusedVariableRule;

/**
 * @extends RuleTestCase<UnusedVariableRule>
 */
#[CoversClass(UnusedVariableRule::class)]
final class UnusedVariableRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createReflectionProvider();

        return new UnusedVariableRule($broker);
    }

    public function testUnusedVariable(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/UnusedVariableRule/fixture.php',
            ],
            [
                [
                    'Function foo() has an unused variable $var1.',
                    7,
                ],
                [
                    'Function foo() has an unused variable $var10.',
                    49,
                ],
                [
                    'Closure function has an unused variable $var5bis.',
                    27,
                ],
            ]
        );
    }

    #[RequiresPhp('>=7.4')]
    public function testUnusedVariable74(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/UnusedVariableRule/fixture74.php',
            ],
            [
                [
                    'Function foo() has an unused variable $var1.',
                    7,
                ],
            ]
        );
    }
}
