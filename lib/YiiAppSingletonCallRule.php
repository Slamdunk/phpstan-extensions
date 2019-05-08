<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

final class YiiAppSingletonCallRule implements Rule
{
    public function getNodeType(): string
    {
        return StaticPropertyFetch::class;
    }

    /**
     * @param \PhpParser\Node\Stmt\Goto_ $node
     * @param \PHPStan\Analyser\Scope    $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node instanceof StaticPropertyFetch) {
            return [];
        }

        return ['You cannot access Yii application singleton in this namespace.'];
    }
}
