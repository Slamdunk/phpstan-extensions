<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;

final class StringToClassRule implements Rule
{
    private $broker;

    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function getNodeType(): string
    {
        return String_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $className = $node->value;
        $messages = array();
        if (! $this->broker->hasClass($className)) {
            return $messages;
        }

        $classRef = $this->broker->getClass($className)->getNativeReflection();
        if ($classRef->isInternal() and $classRef->getName() !== $className) {
            return $messages;
        }

        return array(
            \sprintf('Class %s should be written with ::class notation, string found.', $className),
        );
    }
}
