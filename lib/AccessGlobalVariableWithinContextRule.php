<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Variable>
 */
final class AccessGlobalVariableWithinContextRule implements Rule
{
    private const GLOBALS = [
        'GLOBALS'  => true,
        '_SERVER'  => true,
        '_GET'     => true,
        '_POST'    => true,
        '_FILES'   => true,
        '_REQUEST' => true,
        '_SESSION' => true,
        '_ENV'     => true,
        '_COOKIE'  => true,
        'argc'     => true,
        'argv'     => true,
    ];
    private ReflectionProvider $broker;
    private string $contextBaseClassOrInterface;

    public function __construct(ReflectionProvider $broker, string $contextBaseClassOrInterface)
    {
        $this->broker                       = $broker;
        $this->contextBaseClassOrInterface  = $contextBaseClassOrInterface;
    }

    public function getNodeType(): string
    {
        return Variable::class;
    }

    /** @return list<RuleError> */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! \is_string($node->name)) {
            return [];
        }

        if (! isset(self::GLOBALS[$node->name])) {
            return [];
        }

        if (! $scope->isInClass()) {
            return [];
        }

        $classReflection = $scope->getClassReflection();
        if (! $classReflection->isSubclassOf($this->contextBaseClassOrInterface)) {
            return [];
        }

        $modelBaseClassOrInterface = $this->broker->getClass($this->contextBaseClassOrInterface);

        return [RuleErrorBuilder::message(\sprintf(
            'Class %s %s %s and uses $%s: accessing globals in this context is considered an anti-pattern',
            $classReflection->getDisplayName(),
            $modelBaseClassOrInterface->isInterface() ? 'implements' : 'extends',
            $this->contextBaseClassOrInterface,
            $node->name
        ))->identifier('globalAccess.outOfContext')->build()];
    }
}
