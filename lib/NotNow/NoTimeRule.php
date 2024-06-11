<?php

declare(strict_types=1);

namespace SlamPhpStan\NotNow;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FuncCall>
 */
final class NoTimeRule implements Rule
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

    /** @return list<RuleError> */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Node\Name) {
            return [];
        }

        if ('time' !== $this->reflectionProvider->resolveFunctionName($node->name, $scope)) {
            return [];
        }

        return [RuleErrorBuilder::message('Calling time() directly is forbidden, rely on a clock abstraction like lcobucci/clock')->identifier('timecall.forbidden')->build()];
    }
}
