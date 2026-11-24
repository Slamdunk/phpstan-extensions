<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\NoUselessInlineAnnotationsRule;

/**
 * @covers \SlamPhpStan\NoUselessInlineAnnotationsRule
 */
final class NoUselessInlineAnnotationsRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new NoUselessInlineAnnotationsRule($broker);
    }

    public function testClassConstant()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/NoUselessInlineAnnotationsRule/fixture.php',
            ],
            [
                [
                    'Function mkdir is unsafe to use, rely on Symfony component Filesystem::mkdir instead.',
                    9,
                ],
                [
                    'Function readlink is unsafe to use, rely on Symfony component Filesystem::readlink instead.',
                    12,
                ],
                [
                    'Function touch is unsafe to use, rely on Symfony component Filesystem::touch instead.',
                    15,
                ],
            ]
        );
    }
}
