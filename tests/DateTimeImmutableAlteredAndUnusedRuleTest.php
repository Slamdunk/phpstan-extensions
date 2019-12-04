<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\DateTimeImmutableAlteredAndUnusedRule;

/**
 * @covers \SlamPhpStan\DateTimeImmutableAlteredAndUnusedRule
 */
final class DateTimeImmutableAlteredAndUnusedRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker          = $this->createBroker();
        $ruleLevelHelper = new RuleLevelHelper($broker, true, false, true);

        return new DateTimeImmutableAlteredAndUnusedRule(
            $broker,
            $ruleLevelHelper
        );
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/DateTimeImmutableAlteredAndUnusedRule/fixture.php',
            ],
            [
                [
                    'The method DateTimeImmutable::add is invoked without using its result',
                    5,
                ],
                [
                    'The method DateTimeImmutable::sub is invoked without using its result',
                    8,
                ],
            ]
        );
    }
}
