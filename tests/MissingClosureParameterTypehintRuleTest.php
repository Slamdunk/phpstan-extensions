<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\MissingClosureParameterTypehintRule;

/**
 * @covers \SlamPhpStan\MissingClosureParameterTypehintRule
 */
final class MissingClosureParameterTypehintRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new MissingClosureParameterTypehintRule();
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/MissingClosureParameterTypehintRule/fixture.php',
            ],
            [
                [
                    'Parameter #1 $class of anonymous function has no typehint.',
                    7,
                ],
                [
                    'Parameter #2 $int of anonymous function has no typehint.',
                    8,
                ],
            ]
        );
    }
}
