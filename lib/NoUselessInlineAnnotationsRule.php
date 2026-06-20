<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;

final class NoUselessInlineAnnotationsRule implements Rule
{
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
        return Assign::class;
    }

    /**
     * @param \PhpParser\Node\Expr\Assign $node
     * @param \PHPStan\Analyser\Scope     $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        r($node);
    }
}
