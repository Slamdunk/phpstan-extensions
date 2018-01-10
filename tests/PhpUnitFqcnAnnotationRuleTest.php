<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\PhpUnitFqcnAnnotationRule;

/**
 * @covers \SlamPhpStan\PhpUnitFqcnAnnotationRule
 */
final class PhpUnitFqcnAnnotationRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new PhpUnitFqcnAnnotationRule($broker);
    }

    public function testClassConstant()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/PhpUnitFqcnAnnotation.php',
            ],
            [
                [
                    'Class PhpUnitFqcnAnnotation does not exist (line: 14).',
                    23,
                ],
                [
                    'Class PhpUnitFqcnAnnotation does not exist (line: 15).',
                    23,
                ],
                [
                    'Class FooBar\PhpUnitFqcnAnnotation does not exist (line: 26).',
                    34,
                ],
                [
                    'Class FooBar\PhpUnitFqcnAnnotation does not exist (line: 27).',
                    34,
                ],
                [
                    'Class PhpUnitFqcnAnnotation does not exist (line: 37).',
                    43,
                ],
                [
                    'Class PhpUnitFqcnAnnotation does not exist (line: 38).',
                    43,
                ],
                [
                    'Class FooBar\PhpUnitFqcnAnnotation does not exist (line: 46).',
                    -1,
                ],
                [
                    'Class FooBar\PhpUnitFqcnAnnotation does not exist (line: 47).',
                    -1,
                ],
            ]
        );
    }
}
