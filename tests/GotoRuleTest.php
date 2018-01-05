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

    public function testClassConstant()
    {
        $this->analyse(
            array(
                __DIR__ . '/TestAsset/Goto.php',
            ),
            array(
                array(
                    'No goto, cmon!',
                    6,
                ),
            )
        );
    }
}
