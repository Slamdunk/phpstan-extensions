<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\ClassNotationRule;

/**
 * @covers \SlamPhpStan\ClassNotationRule
 */
final class ClassNotationRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new ClassNotationRule($broker);
    }

    public function testClassConstant()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/ClassNotation.php',
            ],
            [
                [
                    'Interface SlamPhpStan\Tests\TestAsset\A should end with "Interface" suffix.',
                    5,
                ],
                [
                    'Abstract class SlamPhpStan\Tests\TestAsset\B should start with "Abstract" prefix.',
                    9,
                ],
                [
                    'Abstract class SlamPhpStan\Tests\TestAsset\Abstract_B should start with "Abstract" prefix.',
                    13,
                ],
                [
                    'Trait SlamPhpStan\Tests\TestAsset\C should end with "Trait" suffix.',
                    17,
                ],
                [
                    'Exception class SlamPhpStan\Tests\TestAsset\E should end with "Exception" suffix.',
                    20,
                ],
            ]
        );
    }
}
