<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

final class MissingClosureParameterTypehintRule implements Rule
{
    public function getNodeType(): string
    {
        return \PhpParser\Node\Expr\Closure::class;
    }

    /**
     * @param \PhpParser\Node\Expr\Closure $node
     *
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
