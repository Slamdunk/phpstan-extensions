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

    public function testClassConstant()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/DateTimeImmutableAlteredAndUnusedRule/fixture.php',
            ],
            [
                [
                    \sprintf('A %s class is altered but unused.', \DateTimeImmutable::class),
                    5,
                ],
                [
                    \sprintf('A %s class is altered but unused.', \DateTimeImmutable::class),
                    8,
                ],
            ],
        );
    }
}
