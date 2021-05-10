<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\AccessStaticPropertyWithinModelContextRule;

/**
 * @covers \SlamPhpStan\AccessStaticPropertyWithinModelContextRule
 *
 * @extends RuleTestCase<AccessStaticPropertyWithinModelContextRule>
 */
final class AccessStaticPropertyWithinModelContextRuleTest extends RuleTestCase
{
    private string $modelBaseClassOrInterface;

    private string $singletonAccessor;

    /**
     * @param string  $name
     * @param mixed[] $data
     * @param string  $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->modelBaseClassOrInterface = TestAsset\AccessStaticPropertyWithinModelContextRule\YiiAlikeActiveRecordInterface::class;
        $this->singletonAccessor         = TestAsset\AccessStaticPropertyWithinModelContextRule\YiiAlikeBaseYii::class;

        parent::__construct($name, $data, $dataName);
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
