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

        $functionName = $this->reflectionProvider->resolveFunctionName($node->name, $scope);

        if (! \in_array($functionName, ['time', 'microtime'], true)) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                \sprintf('Calling %s() directly is forbidden, rely on a clock abstraction like lcobucci/clock', $functionName)
            )
                ->identifier('timecall.forbidden')->build()];
    }
}
