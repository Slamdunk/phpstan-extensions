<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use SlamPhpStan\AccessGlobalVariableWithinContextRule;

/**
 * @extends RuleTestCase<AccessGlobalVariableWithinContextRule>
 */
#[CoversClass(AccessGlobalVariableWithinContextRule::class)]
final class AccessGlobalVariableWithinContextRuleTest extends RuleTestCase
{
    private string $contextBaseClassOrInterface;

    protected function setUp(): void
    {
        $this->contextBaseClassOrInterface = TestAsset\AccessGlobalVariableWithinContextRule\YiiAlikeActiveRecordInterface::class;
    }

    protected function getRule(): Rule
    {
        $broker = $this->createReflectionProvider();

        return new AccessGlobalVariableWithinContextRule($broker, $this->contextBaseClassOrInterface);
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/AccessGlobalVariableWithinContextRule/fixture.php',
            ],
            [
                [
                    \sprintf(
                        'Class %s implements %s and uses $_POST: accessing globals in this context is considered an anti-pattern',
                        TestAsset\AccessGlobalVariableWithinContextRule\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    8,
                ],
                [
                    \sprintf(
                        'Class %s implements %s and uses $GLOBALS: accessing globals in this context is considered an anti-pattern',
                        TestAsset\AccessGlobalVariableWithinContextRule\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    9,
                ],
                [
                    \sprintf(
                        'Class %s implements %s and uses $argc: accessing globals in this context is considered an anti-pattern',
                        TestAsset\AccessGlobalVariableWithinContextRule\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    10,
                ],
            ]
        );
    }
}
