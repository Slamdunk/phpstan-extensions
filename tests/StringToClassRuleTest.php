<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use SlamPhpStan\StringToClassRule;

/**
 * @extends RuleTestCase<StringToClassRule>
 */
#[CoversClass(StringToClassRule::class)]
final class StringToClassRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createReflectionProvider();

        return new StringToClassRule($broker);
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/StringToClassRule/fixture.php',
            ],
            [
                [
                    \sprintf('Class %s should be written with ::class notation, string found.', TestAsset\StringToClassRule\FooStringToClass::class),
                    12,
                ],
                [
                    \sprintf('Class %s should be written with ::class notation, string found.', TestAsset\StringToClassRule\FooStringToClass::class),
                    13,
                ],
                [
                    'Class DateTimeImmutable should be written with ::class notation, string found.',
                    14,
                ],
                [
                    'Class stdClass should be written with ::class notation, string found.',
                    15,
                ],
                [
                    \sprintf('Class %s should be written with ::class notation, string found.', TestAsset\StringToClassRule\FooStringToClass::class),
                    17,
                ],
                [
                    \sprintf('Class %s should be written with ::class notation, string found.', TestAsset\StringToClassRule\FooStringToClass::class),
                    18,
                ],
                [
                    'Class DateTimeImmutable should be written with ::class notation, string found.',
                    19,
                ],
                [
                    'Class stdClass should be written with ::class notation, string found.',
                    20,
                ],
            ]
        );
    }
}
