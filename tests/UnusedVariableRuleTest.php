<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\UnusedVariableRule;

/**
 * @covers \SlamPhpStan\UnusedVariableRule
 */
final class UnusedVariableRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new UnusedVariableRule();
    }

    public function testClassConstant()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/UnusedVariableRule.php',
            ],
            [
                [
                    'Function foo() has an unused variable $var1 at line 7.',
                    5,
                ],
                [
                    'Function foo() has an unused variable $var10 at line 49.',
                    5,
                ],
                [
                    'Closure function has an unused variable $var5bis at line 27.',
                    24,
                ],
            ]
        );
    }
}
