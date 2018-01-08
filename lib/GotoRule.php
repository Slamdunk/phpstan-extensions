<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Stmt\Goto_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

final class GotoRule implements Rule
{
    public function getNodeType(): string
    {
        return Goto_::class;
    }

    /**
     * @param \PhpParser\Node\Stmt\Goto_ $node
     * @param \PHPStan\Analyser\Scope    $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return ['No goto, cmon!'];
    }
}
