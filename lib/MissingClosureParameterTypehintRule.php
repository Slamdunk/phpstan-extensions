<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<Closure>
 */
final class MissingClosureParameterTypehintRule implements Rule
{
    public function getNodeType(): string
    {
        return Closure::class;
    }

    /**
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];

        foreach ($node->params as $index => $param) {
            if (null !== $param->type || ! $param->var instanceof Node\Expr\Variable || ! \is_string($param->var->name)) {
                continue;
            }

            $messages[] = \sprintf('Parameter #%d $%s of anonymous function has no typehint.', 1 + $index, $param->var->name);
        }

        return $messages;
    }
}
