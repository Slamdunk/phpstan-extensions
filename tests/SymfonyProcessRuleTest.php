<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use SlamPhpStan\SymfonyProcessRule;

/**
 * @extends RuleTestCase<SymfonyProcessRule>
 */
#[CoversClass(SymfonyProcessRule::class)]
final class SymfonyProcessRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new SymfonyProcessRule($broker);
    }

    public function testClassConstant(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/SymfonyProcessRule/fixture.php',
            ],
            [
                [
                    'Function shell_exec is unsafe to use, rely on Symfony\\Process component instead.',
                    11,
                ],
                [
                    'Function passthru is unsafe to use, rely on Symfony\\Process component instead.',
                    12,
                ],
                [
                    'Function proc_open is unsafe to use, rely on Symfony\\Process component instead.',
                    13,
                ],
            ]
        );
    }
}
