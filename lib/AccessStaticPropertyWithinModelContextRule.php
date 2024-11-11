<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<StaticPropertyFetch>
 */
final class AccessStaticPropertyWithinModelContextRule implements Rule
{
    private ReflectionProvider $broker;
    private string $modelBaseClassOrInterface;
    private string $singletonAccessor;

    public function __construct(ReflectionProvider $broker, string $modelBaseClassOrInterface, string $singletonAccessor)
    {
        $this->broker                    = $broker;
        $this->modelBaseClassOrInterface = $modelBaseClassOrInterface;
        $this->singletonAccessor         = $singletonAccessor;
    }

    public function getNodeType(): string
    {
        return StaticPropertyFetch::class;
    }

    /** @return list<RuleError> */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->class instanceof Node\Name || ! $node->name instanceof Node\VarLikeIdentifier) {
            return [];
        }

        if (! $scope->isInClass()) {
            return [];
        }

        $classReflection = $scope->getClassReflection();
        if (! $classReflection->isSubclassOf($this->modelBaseClassOrInterface)) {
            return [];
        }

        $baseYiiClassName = $scope->resolveName($node->class);
        if (! $this->broker->hasClass($baseYiiClassName)) {
            return [];
        }

        $baseYiiClass = $this->broker->getClass($baseYiiClassName);
        if ($baseYiiClassName !== $this->singletonAccessor && ! $baseYiiClass->isSubclassOf($this->singletonAccessor)) {
            return [];
        }

        $modelBaseClassOrInterface = $this->broker->getClass($this->modelBaseClassOrInterface);

        return [RuleErrorBuilder::message(\sprintf(
            'Class %s %s %s and uses %s::$%s: accessing a singleton in this context is considered an anti-pattern',
            $classReflection->getDisplayName(),
            $modelBaseClassOrInterface->isInterface() ? 'implements' : 'extends',
            $this->modelBaseClassOrInterface,
            $this->singletonAccessor,
            (string) $node->name
        ))->identifier('singletonAccess.outOfContext')->build()];
    }
}
