<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<FuncCall>
 */
final class SymfonyFilesystemRule implements Rule
{
    private const CALL_MAP = [
        'copy'              => ['copy'],
        'mkdir'             => ['mkdir'],
        'file_exists'       => ['exists'],
        'touch'             => ['touch'],
        'rmdir'             => ['remove'],
        'unlink'            => ['remove'],
        'chmod'             => ['chmod'],
        'lchown'            => ['chown'],
        'chown'             => ['chown'],
        'lchgrp'            => ['chgrp'],
        'chgrp'             => ['chgrp'],
        'rename'            => ['rename'],
        'symlink'           => ['symlink'],
        'link'              => ['hardlink'],
        'readlink'          => ['readlink'],
        'tempnam'           => ['tempnam'],
        'file_put_contents' => ['dumpFile', 'appendToFile'],
    ];

    private Broker $broker;

    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
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
        if (! ($node->name instanceof Name)) {
            return [];
        }

        if (! $this->broker->hasFunction($node->name, $scope)) {
            return [];
        }

        $calledFunctionName = $this->broker->resolveFunctionName($node->name, $scope);
        if (! isset(self::CALL_MAP[$calledFunctionName])) {
            return [];
        }

        return [\sprintf(
            'Function %s is unsafe to use, rely on Symfony component Filesystem::%s instead.',
            $calledFunctionName,
            \implode(' or Filesystem::', self::CALL_MAP[$calledFunctionName])
        )];
    }
}
