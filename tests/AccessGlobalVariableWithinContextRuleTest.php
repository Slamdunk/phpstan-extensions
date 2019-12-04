<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use SlamPhpStan\AccessGlobalVariableWithinContextRule;

/**
 * @covers \SlamPhpStan\AccessGlobalVariableWithinContextRule
 */
final class AccessGlobalVariableWithinContextRuleTest extends RuleTestCase
{
    /**
     * @var string
     */
    private $contextBaseClassOrInterface;

    /**
     * @param string  $name
     * @param mixed[] $data
     * @param string  $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->contextBaseClassOrInterface = TestAsset\AccessGlobalVariableWithinContextRule\YiiAlikeActiveRecordInterface::class;

        parent::__construct($name, $data, $dataName);
    }

    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

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
                    \sprintf('Class %s implements %s and uses $_POST: accessing globals in this context is considered an anti-pattern',
                        TestAsset\AccessGlobalVariableWithinContextRule\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    8,
                ],
                [
                    \sprintf('Class %s implements %s and uses $GLOBALS: accessing globals in this context is considered an anti-pattern',
                        TestAsset\AccessGlobalVariableWithinContextRule\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    9,
                ],
                [
                    \sprintf('Class %s implements %s and uses $argc: accessing globals in this context is considered an anti-pattern',
                        TestAsset\AccessGlobalVariableWithinContextRule\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    10,
                ],
            ]
        );
    }
}
