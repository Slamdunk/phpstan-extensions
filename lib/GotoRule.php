<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Stmt\Goto_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Goto_>
 */
final class GotoRule implements Rule
{
    public function getNodeType(): string
    {
        return Goto_::class;
    }

    /** @return list<RuleError> */
    public function processNode(Node $node, Scope $scope): array
    {
        return [RuleErrorBuilder::message('No goto, cmon!')->identifier('goto.forbidden')->build()];
    }
}
