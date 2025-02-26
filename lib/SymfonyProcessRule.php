<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FuncCall>
 */
final class SymfonyProcessRule implements Rule
{
    private const CALL_MAP = [
        'exec'            => true,
        'passthru'        => true,
        'proc_close'      => true,
        'proc_get_status' => true,
        'proc_nice'       => true,
        'proc_open'       => true,
        'proc_terminate'  => true,
        'shell_exec'      => true,
        'system'          => true,
    ];

    private ReflectionProvider $broker;

    public function __construct(ReflectionProvider $broker)
    {
        $this->broker = $broker;
    }

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    /**
     * @param FuncCall $node
     *
     * @return list<RuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Name) {
            return [];
        }

        if (! $this->broker->hasFunction($node->name, $scope)) {
            return [];
        }

        $calledFunctionName = $this->broker->resolveFunctionName($node->name, $scope);
        if (! isset(self::CALL_MAP[$calledFunctionName])) {
            return [];
        }

        return [RuleErrorBuilder::message(\sprintf('Function %s is unsafe to use, rely on Symfony\Process component instead.', $calledFunctionName))->identifier('syscall.unsafe')->build()];
    }
}
