<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;

final class AccessStaticPropertyWithinModelContextRule implements Rule
{
    /**
     * @var Broker
     */
    private $broker;

    /**
     * @var string
     */
    private $modelBaseClassOrInterface;

    /**
     * @var string
     */
    private $singletonAccessor;

    public function __construct(Broker $broker, string $modelBaseClassOrInterface, string $singletonAccessor)
    {
        $this->broker                    = $broker;
        $this->modelBaseClassOrInterface = $modelBaseClassOrInterface;
        $this->singletonAccessor         = $singletonAccessor;
    }

    public function getNodeType(): string
    {
        return StaticPropertyFetch::class;
    }

    /**
     * @param \PhpParser\Node\Expr\StaticPropertyFetch $node
     * @param \PHPStan\Analyser\Scope                  $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->class instanceof Node\Name || ! $node->name instanceof Node\VarLikeIdentifier) {
            return [];
        }

        if (! $scope->isInClass()) {
            return [];
        }

        $classReflection = $scope->getClassReflection();
        if (null === $classReflection || ! $classReflection->isSubclassOf($this->modelBaseClassOrInterface)) {
            return [];
        }

        $baseYiiClassName = (string) $node->class;
        if (! $this->broker->hasClass($baseYiiClassName)) {
            return [];
        }

        $baseYiiClass = $this->broker->getClass($baseYiiClassName);
        if ($baseYiiClassName !== $this->singletonAccessor && ! $baseYiiClass->isSubclassOf($this->singletonAccessor)) {
            return [];
        }

        return [\sprintf('Class %s extends or implements %s and uses %s::$%s: in a model accessing to a singleton is considered an anti-pattern',
            $classReflection->getName(),
            $this->modelBaseClassOrInterface,
            $this->singletonAccessor,
            (string) $node->name
        )];
    }
}
