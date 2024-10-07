<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use SlamPhpStan\ClassNotationRule;

/**
 * @covers \SlamPhpStan\ClassNotationRule
 *
 * @extends RuleTestCase<ClassNotationRule>
 */
#[CoversClass(ClassNotationRule::class)]
final class ClassNotationRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createReflectionProvider();

        return new ClassNotationRule($broker);
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/ClassNotation/fixture.php',
            ],
            [
                [
                    \sprintf('Interface %s should end with "Interface" suffix.', TestAsset\ClassNotation\A::class),
                    5,
                ],
                [
                    \sprintf('Abstract class %s should start with "Abstract" prefix.', TestAsset\ClassNotation\B::class),
                    9,
                ],
                [
                    \sprintf('Abstract class %s should start with "Abstract" prefix.', TestAsset\ClassNotation\Abstract_B::class),
                    13,
                ],
                [
                    \sprintf('Trait %s should end with "Trait" suffix.', TestAsset\ClassNotation\C::class),
                    17,
                ],
                [
                    \sprintf('Exception class %s should end with "Exception" suffix.', TestAsset\ClassNotation\E::class),
                    20,
                ],
            ]
        );
    }
}
