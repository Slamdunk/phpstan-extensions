<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;

final class SymfonyProcessRule implements Rule
{
    /**
     * @var bool[]
     */
    private $callMap = [
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

    /**
     * @var Broker
     */
    private $broker;

    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    /**
     * @param \PhpParser\Node\Expr\FuncCall $node
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! ($node->name instanceof \PhpParser\Node\Name)) {
            return [];
        }

        if (! $this->broker->hasFunction($node->name, $scope)) {
            return [];
        }

        $calledFunctionName = $this->broker->resolveFunctionName($node->name, $scope);
        if (! isset($this->callMap[$calledFunctionName])) {
            return [];
        }

        return [\sprintf('Function %s is unsafe to use, rely on Symfony\Process component instead.', $calledFunctionName)];
    }
}
