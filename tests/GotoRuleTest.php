<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\GotoRule;

/**
 * @covers \SlamPhpStan\GotoRule
 */
final class GotoRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new GotoRule();
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/GotoRule/fixture.php',
            ],
            [
                [
                    'No goto, cmon!',
                    6,
                ],
            ]
        );
    }
}
