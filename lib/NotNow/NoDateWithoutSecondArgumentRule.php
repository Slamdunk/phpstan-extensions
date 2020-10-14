<?php

declare(strict_types=1);

namespace SlamPhpStan\NotNow;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<FuncCall>
 */
final class NoDateWithoutSecondArgumentRule implements Rule
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

        if ('date' !== $this->reflectionProvider->resolveFunctionName($node->name, $scope)) {
            return [];
        }

        if (2 === \count($node->args)) {
            return [];
        }

        return ['Calling date() without the second parameter is forbidden, rely on a clock abstraction like lcobucci/clock'];
    }
}
