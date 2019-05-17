<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

final class DateTimeImmutableAlteredAndUnusedRule implements Rule
{
    /** @var \PHPStan\Broker\Broker */
    private $broker;

    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;

    private $alteringMethods = [
        'add'          => true,
        'modify'       => true,
        'setDate'      => true,
        'setISODate'   => true,
        'setTime'      => true,
        'setTimestamp' => true,
        'setTimezone'  => true,
        'sub'          => true,
    ];

    public function __construct(
        Broker $broker,
        RuleLevelHelper $ruleLevelHelper
    ) {
        $this->broker          = $broker;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /**
     * @param \PhpParser\Node\Expr\MethodCall $node
     * @param \PHPStan\Analyser\Scope         $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Node\Identifier) {
            return [];
        }

        $name       = $node->name->name;
        $typeResult = $this->ruleLevelHelper->findTypeToCheck(
            $scope,
            $node->var,
            \sprintf('Call to method %s() on an unknown class %%s.', $name),
            static function (Type $type) use ($name): bool {
                return $type->canCallMethods()->yes() && $type->hasMethod($name)->yes();
            }
        );
        $type = $typeResult->getType();
        if (! $type instanceof ObjectType) {
            return [];
        }

        $className = $type->getClassName();
        if (! $this->broker->hasClass($className)) {
            return [];
        }
        $class = $this->broker->getClass($className);
        if (\DateTimeImmutable::class !== $className && ! $class->isSubclassOf(\DateTimeImmutable::class)) {
            return [];
        }
        $methodName = (string) $node->name;
        if (! isset($this->alteringMethods[$methodName])) {
            return [];
        }

        // How to know if $node is assigned/used to anything or
        // just called in a dedicated line?

        return [];
    }
}
