<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use SlamPhpStan\AccessStaticPropertyWithinModelContextRule;

/**
 * @covers \SlamPhpStan\AccessStaticPropertyWithinModelContextRule
 *
 * @extends RuleTestCase<AccessStaticPropertyWithinModelContextRule>
 */
#[CoversClass(AccessStaticPropertyWithinModelContextRule::class)]
final class AccessStaticPropertyWithinModelContextRuleTest extends RuleTestCase
{
    private string $modelBaseClassOrInterface;

    private string $singletonAccessor;

    protected function setUp(): void
    {
        $this->modelBaseClassOrInterface = TestAsset\AccessStaticPropertyWithinModelContextRule\YiiAlikeActiveRecordInterface::class;
        $this->singletonAccessor         = TestAsset\AccessStaticPropertyWithinModelContextRule\YiiAlikeBaseYii::class;
    }

    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new AccessStaticPropertyWithinModelContextRule(
            $broker,
            $this->modelBaseClassOrInterface,
            $this->singletonAccessor
        );
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/AccessStaticPropertyWithinModelContextRule/fixture.php',
            ],
            [
                [
                    \sprintf(
                        'Class %s implements %s and uses %s::$app: accessing a singleton in this context is considered an anti-pattern',
                        TestAsset\AccessStaticPropertyWithinModelContextRule\ModelAccessingYiiAppSingletons::class,
                        $this->modelBaseClassOrInterface,
                        $this->singletonAccessor
                    ),
                    8,
                ],
                [
                    \sprintf(
                        'Class %s implements %s and uses %s::$app: accessing a singleton in this context is considered an anti-pattern',
                        TestAsset\AccessStaticPropertyWithinModelContextRule\ModelAccessingYiiAppSingletons::class,
                        $this->modelBaseClassOrInterface,
                        $this->singletonAccessor
                    ),
                    10,
                ],
            ]
        );
    }
}
