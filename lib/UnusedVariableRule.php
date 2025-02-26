<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FunctionLike>
 */
final class UnusedVariableRule implements Rule
{
    private const GLOBAL_VARIABLES = [
        'GLOBALS'  => true,
        '_COOKIE'  => true,
        '_ENV'     => true,
        '_FILES'   => true,
        '_GET'     => true,
        '_POST'    => true,
        '_REQUEST' => true,
        '_SERVER'  => true,
        '_SESSION' => true,
    ];

    public function __construct(
        private readonly ReflectionProvider $broker,
    ) {}

    public function getNodeType(): string
    {
        return FunctionLike::class;
    }

    /** @return RuleError[] */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        $parameters = [];
        foreach ($node->getParams() as $parameter) {
            $variable = $parameter->var;
            if ($variable instanceof Variable && \is_string($variable->name)) {
                $parameters[$variable->name] = true;
            }
        }
        if ($node instanceof Closure) {
            foreach ($node->uses as $use) {
                if (\is_string($use->var->name)) {
                    $parameters[$use->var->name] = true;
                }
            }
        }

        $unusedVariables = [];
        $usedVariables   = [];
        $this->gatherVariablesUsage($node, $scope, $unusedVariables, $usedVariables, $parameters, $node);

        foreach ($unusedVariables as $varName => $var) {
            if (! isset($usedVariables[$varName])) {
                $messages[] = RuleErrorBuilder::message(\sprintf(
                    '%s has an unused variable $%s.',
                    \property_exists($node, 'name')
                        ? \sprintf('Function %s()', $node->name)
                        : 'Closure function',
                    $varName
                ))->line($var->getAttribute('startLine'))->build();
            }
        }

        return $messages;
    }

    /**
     * @param mixed[] $unusedVariables
     * @param bool[]  $usedVariables
     * @param mixed[] $parameters
     */
    private function gatherVariablesUsage(Node $node, Scope $scope, array & $unusedVariables, array & $usedVariables, array $parameters = [], ?Node $originalNode = null): void
    {
        if ($node instanceof FunctionLike
            && $node !== $originalNode
            && ! $node instanceof ArrowFunction
        ) {
            if ($node instanceof Closure) {
                foreach ($node->uses as $use) {
                    if (\is_string($use->var->name)) {
                        $usedVariables[$use->var->name] = true;
                    }
                }
            }

            return;
        }

        $this->captureVariablesUsedByCompactFunction($node, $scope, $usedVariables);

        if ($node instanceof Assign) {
            if ($node->var instanceof Variable) {
                if (\is_string($node->var->name) && ! isset($parameters[$node->var->name]) && ! isset(self::GLOBAL_VARIABLES[$node->var->name])) {
                    $unusedVariables[$node->var->name] = $node->var;
                }
            } else {
                if (\property_exists($node->var, 'var') && $node->var->var instanceof Node) {
                    $this->gatherVariablesUsage($node->var->var, $scope, $unusedVariables, $usedVariables, $parameters);
                }
                if (\property_exists($node->var, 'dim') && $node->var->dim instanceof Node) {
                    $this->gatherVariablesUsage($node->var->dim, $scope, $unusedVariables, $usedVariables, $parameters);
                }
                if (\property_exists($node->var, 'name') && $node->var->name instanceof Node) {
                    $this->gatherVariablesUsage($node->var->name, $scope, $unusedVariables, $usedVariables, $parameters);
                }
            }
        }
        if ($node instanceof Variable) {
            if (\is_string($node->name)) {
                $usedVariables[$node->name] = true;
            } elseif ($node->name instanceof String_) {
                $usedVariables[$node->name->value] = true;
            } else {
                $this->gatherVariablesUsage($node->name, $scope, $unusedVariables, $usedVariables, $parameters);
            }
        }

        foreach ($node->getSubNodeNames() as $nodeName) {
            if ('var' === $nodeName && $node instanceof Assign) {
                continue;
            }
            if ($node->{$nodeName} instanceof Node) {
                $this->gatherVariablesUsage($node->{$nodeName}, $scope, $unusedVariables, $usedVariables, $parameters);
            } elseif (\is_iterable($node->{$nodeName})) {
                foreach ($node->{$nodeName} as $subNode) {
                    if ($subNode instanceof Node) {
                        $this->gatherVariablesUsage($subNode, $scope, $unusedVariables, $usedVariables, $parameters);
                    }
                }
            }
        }
    }

    /** @param bool[] $usedVariables */
    private function captureVariablesUsedByCompactFunction(Node $node, Scope $scope, array & $usedVariables): void
    {
        if (! $this->isCompactFunction($node, $scope)) {
            return;
        }

        foreach ($node->args as $arg) {
            if ($arg->value instanceof String_) {
                $usedVariables[$arg->value->value] = true;
            }
        }
    }

    private function isCompactFunction(Node $node, Scope $scope): bool
    {
        if (! $node instanceof FuncCall) {
            return false;
        }
        if (! $node->name instanceof Name) {
            return false;
        }
        if (! $this->broker->hasFunction($node->name, $scope)) {
            return false;
        }
        $calledFunctionName = $this->broker->resolveFunctionName($node->name, $scope);

        return 'compact' === $calledFunctionName;
    }
}
