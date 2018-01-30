<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

final class UnusedVariableRule implements Rule
{
    public function getNodeType(): string
    {
        return FunctionLike::class;
    }

    /**
     * @param \PhpParser\Node\FunctionLike $node
     * @param \PHPStan\Analyser\Scope      $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        $parameters = [];
        foreach ($node->getParams() as $parameter) {
            $parameters[$parameter->name] = true;
        }
        if ($node instanceof Closure) {
            foreach ($node->uses as $use) {
                $parameters[$use->var] = true;
            }
        }

        $unusedVariables = [];
        $usedVariables = [];
        $this->gatherVariablesUsage($node, $unusedVariables, $usedVariables, $parameters, $node);

        foreach ($unusedVariables as $varName => $var) {
            if (! isset($usedVariables[$varName])) {
                $messages[] = \sprintf('[Line %3s] %s has an unused variable $%s.',
                    $var->getAttribute('startLine'),
                    \in_array('name', $node->getSubNodeNames(), true) && isset($node->name)
                        ? \sprintf('Function %s()', $node->name)
                        : 'Closure function',
                    $varName
                );
            }
        }

        return $messages;
    }

    private function gatherVariablesUsage(Node $node, array & $unusedVariables, array & $usedVariables, array $parameters = [], Node $originalNode = null): void
    {
        if ($node instanceof FunctionLike && $node !== $originalNode) {
            if ($node instanceof Closure) {
                foreach ($node->uses as $use) {
                    $usedVariables[$use->var] = true;
                }
            }

            return;
        }
        if ($node instanceof Assign) {
            if ($node->var instanceof Variable) {
                if (\is_string($node->var->name) && ! isset($parameters[$node->var->name])) {
                    $unusedVariables[$node->var->name] = $node->var;
                }
            } elseif ($node->var instanceof PropertyFetch) {
                $this->gatherVariablesUsage($node->var->var, $unusedVariables, $usedVariables, $parameters);
            } elseif ($node->var instanceof ArrayDimFetch) {
                if ($node->var->var instanceof Node) {
                    $this->gatherVariablesUsage($node->var->var, $unusedVariables, $usedVariables, $parameters);
                }
                if ($node->var->dim instanceof Node) {
                    $this->gatherVariablesUsage($node->var->dim, $unusedVariables, $usedVariables, $parameters);
                }
            }
        }
        if ($node instanceof Variable) {
            if (\is_string($node->name)) {
                $usedVariables[$node->name] = true;
            } elseif ($node->name instanceof String_) {
                $usedVariables[$node->name->value] = true;
            } else {
                $this->gatherVariablesUsage($node->name, $unusedVariables, $usedVariables, $parameters);
            }
        }

        foreach ($node->getSubNodeNames() as $nodeName) {
            if ('var' === $nodeName && $node instanceof Assign) {
                continue;
            }
            if ($node->{$nodeName} instanceof Node) {
                $this->gatherVariablesUsage($node->{$nodeName}, $unusedVariables, $usedVariables, $parameters);
            } elseif (\is_iterable($node->{$nodeName})) {
                foreach ($node->{$nodeName} as $subNode) {
                    if ($subNode instanceof Node) {
                        $this->gatherVariablesUsage($subNode, $unusedVariables, $usedVariables, $parameters);
                    }
                }
            }
        }
    }
}
