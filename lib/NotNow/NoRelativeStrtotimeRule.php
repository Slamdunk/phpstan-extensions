<?php

declare(strict_types=1);

namespace SlamPhpStan\NotNow;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Type\ConstantScalarType;

/**
 * @implements Rule<FuncCall>
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
        return FuncCall::class;
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

        $args = $node->getArgs();

        if (1 !== \count($args)) {
            return [];
        }

        $argType = $scope->getType($args[0]->value);
        if (! $argType instanceof ConstantScalarType) {
            return [];
        }

        $value = $argType->getValue();
        if (! \is_string($value) || ! ForbiddenRelativeFormats::isForbidden($value)) {
            return [];
        }

        return [
            \sprintf(
                'Calling strtotime() with relative datetime "%s" without the second argument is forbidden, rely on a clock abstraction like lcobucci/clock',
                $value
            ),
        ];
    }
}
