<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use SlamPhpStan\PhpUnitFqcnAnnotationRule;

/**
 * @extends RuleTestCase<PhpUnitFqcnAnnotationRule>
 */
#[CoversClass(PhpUnitFqcnAnnotationRule::class)]
final class PhpUnitFqcnAnnotationRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new PhpUnitFqcnAnnotationRule($broker);
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/PhpUnitFqcnAnnotation/fixture.php',
            ],
            [
                [
                    'Class PhpUnitFqcnAnnotation does not exist.',
                    14,
                ],
                [
                    'Class PhpUnitFqcnAnnotation does not exist.',
                    15,
                ],
                [
                    'Class FooBar\PhpUnitFqcnAnnotation does not exist.',
                    26,
                ],
                [
                    'Class FooBar\PhpUnitFqcnAnnotation does not exist.',
                    27,
                ],
                [
                    'Class PhpUnitFqcnAnnotation does not exist.',
                    37,
                ],
                [
                    'Class PhpUnitFqcnAnnotation does not exist.',
                    38,
                ],
                [
                    'Class FooBar\PhpUnitFqcnAnnotation does not exist.',
                    46,
                ],
                [
                    'Class FooBar\PhpUnitFqcnAnnotation does not exist.',
                    47,
                ],
            ]
        );
    }
}
