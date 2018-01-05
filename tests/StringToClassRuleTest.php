<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\StringToClassRule;

final class StringToClassRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new StringToClassRule($broker);
    }

    public function testClassConstant()
    {
        $this->analyse(
            array(
                __DIR__ . '/TestAsset/FooStringToClass.php',
            ),
            array(
                array(
                    'Class SlamPhpStan\Tests\TestAsset\FooStringToClass should be written with ::class notation, string found.',
                    12,
                ),
                array(
                    'Class SlamPhpStan\Tests\TestAsset\FooStringToClass should be written with ::class notation, string found.',
                    13,
                ),
                array(
                    'Class DateTimeImmutable should be written with ::class notation, string found.',
                    14,
                ),
                array(
                    'Class stdClass should be written with ::class notation, string found.',
                    15,
                ),
            )
        );
    }
}
