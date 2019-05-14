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

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->contextBaseClassOrInterface = TestAsset\YiiAlikeActiveRecordInterface::class;

        parent::__construct($name, $data, $dataName);
    }

    protected function getRule(): Rule
    {
        $broker = $this->createBroker();

        return new AccessGlobalVariableWithinContextRule($broker, $this->contextBaseClassOrInterface);
    }

    public function testRule()
    {
        $this->analyse(
            [
                __DIR__ . '/TestAsset/AccessGlobalVariableWithinContextRule.php',
            ],
            [
                [
                    \sprintf('Class %s implements %s and uses $_POST: accessing globals in this context is considered an anti-pattern',
                        TestAsset\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    8,
                ],
                [
                    \sprintf('Class %s implements %s and uses $GLOBALS: accessing globals in this context is considered an anti-pattern',
                        TestAsset\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    9,
                ],
                [
                    \sprintf('Class %s implements %s and uses $argc: accessing globals in this context is considered an anti-pattern',
                        TestAsset\ModelAccessingGlobalVariable::class,
                        $this->contextBaseClassOrInterface
                    ),
                    10,
                ],
            ]
        );
    }
}
