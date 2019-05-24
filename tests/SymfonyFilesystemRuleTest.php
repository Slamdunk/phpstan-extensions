<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\SymfonyFilesystemRule;

/**
 * @covers \SlamPhpStan\SymfonyFilesystemRule
 */
final class SymfonyFilesystemRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new SymfonyFilesystemRule($broker);
    }

    public function testClassConstant()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/SymfonyFilesystemRule/fixture.php',
            ],
            [
                [
                    'Function mkdir is unsafe to use, rely on Symfony component Filesystem::mkdir instead.',
                    11,
                ],
                [
                    'Function readlink is unsafe to use, rely on Symfony component Filesystem::readlink instead.',
                    12,
                ],
                [
                    'Function touch is unsafe to use, rely on Symfony component Filesystem::touch instead.',
                    13,
                ],
            ]
        );
    }
}
