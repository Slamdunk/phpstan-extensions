<?php

declare(strict_types=1);

namespace SlamPhpStan\NotNow;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Type\ConstantScalarType;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
final class NoRelativeStrtotimeRule implements Rule
{
    private ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
    }

    /**
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Node\Name) {
            return [];
        }

        if ('strtotime' !== $this->reflectionProvider->resolveFunctionName($node->name, $scope)) {
            return [];
        }

        if (1 !== \count($node->args)) {
            return [];
        }

        $argType = $scope->getType($node->args[0]->value);
        if (! $argType instanceof ConstantScalarType) {
            return [];
        }

        $value = $argType->getValue();
        if (! \is_string($value) || ! ForbiddenRelativeFormats::isForbidden($value)) {
            return [];
        }

        return [
            \sprintf('Calling strtotime() with relative datetime "%s" without the second argument is forbidden, rely on a clock abstraction like lcobucci/clock',
                $value
            ),
        ];
    }
}
