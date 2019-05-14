<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;

final class AccessGlobalVariableWithinContextRule implements Rule
{
    /**
     * @var Broker
     */
    private $broker;

    /**
     * @var string
     */
    private $contextBaseClassOrInterface;

    private $globals = [
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

    public function __construct(Broker $broker, string $contextBaseClassOrInterface)
    {
        $this->broker                       = $broker;
        $this->contextBaseClassOrInterface  = $contextBaseClassOrInterface;
    }

    public function getNodeType(): string
    {
        return Variable::class;
    }

    /**
     * @param \PhpParser\Node\Expr\Variable $node
     * @param \PHPStan\Analyser\Scope       $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $variableName = (string) $node->name;
        if (! isset($this->globals[$variableName])) {
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

        return [\sprintf('Class %s %s %s and uses $%s: accessing globals in this context is considered an anti-pattern',
            $classReflection->getDisplayName(),
            $modelBaseClassOrInterface->isInterface() ? 'implements' : 'extends',
            $this->contextBaseClassOrInterface,
            $variableName
        )];
    }
}
