<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\AccessStaticPropertyWithinModelContextRule;

/**
 * @covers \SlamPhpStan\AccessStaticPropertyWithinModelContextRule
 */
final class AccessStaticPropertyWithinModelContextRuleTest extends RuleTestCase
{
    /**
     * @var string
     */
    private $modelBaseClassOrInterface;

    /**
     * @var string
     */
    private $singletonAccessor;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->modelBaseClassOrInterface = TestAsset\YiiAlikeActiveRecordInterface::class;
        $this->singletonAccessor         = TestAsset\YiiAlikeBaseYii::class;

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

    public function testClassConstant()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/AccessStaticPropertyWithinModelContextRule.php',
            ],
            [
                [
                    \sprintf('Class %s extends or implements %s and uses %s::$app: in a model accessing to a singleton is considered an anti-pattern',
                        TestAsset\ModelAccessingYiiAppSingletons::class,
                        $this->modelBaseClassOrInterface,
                        $this->singletonAccessor
                    ),
                    8,
                ],
                [
                    \sprintf('Class %s extends or implements %s and uses %s::$app: in a model accessing to a singleton is considered an anti-pattern',
                        TestAsset\ModelAccessingYiiAppSingletons::class,
                        $this->modelBaseClassOrInterface,
                        $this->singletonAccessor
                    ),
                    10,
                ],
            ]
        );
    }
}
