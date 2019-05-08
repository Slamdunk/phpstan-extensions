<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\YiiAppSingletonCallRule;

/**
 * @covers \SlamPhpStan\YiiAppSingletonCallRule
 */
final class YiiAppSingletonCallRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new YiiAppSingletonCallRule();
    }

    public function testClassConstant()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/YiiAppSingletonCallRule.php',
            ],
            [
                [
                    'You cannot access Yii application singleton in this namespace.',
                    28,
                ],
                [
                    'You cannot access Yii application singleton in this namespace.',
                    32,
                ],
            ]
        );
    }
}
