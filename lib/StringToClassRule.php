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
        return String_::class;
    }

    /**
     * @param \PhpParser\Node\Scalar\String_ $node
     * @param \PHPStan\Analyser\Scope        $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $className = $node->value;
        if (isset($className[0]) && '\\' === $className[0]) {
            $className = \substr($className, 1);
        }
        $messages  = [];
        if (! \preg_match('/^\\w.+\\w$/u', $className)) {
            return $messages;
        }
        if (! $this->broker->hasClass($className)) {
            return $messages;
        }

        $classRef = $this->broker->getClass($className)->getNativeReflection();
        if ($classRef->isInternal() && $classRef->getName() !== $className) {
            return $messages;
        }

        return [
            \sprintf('Class %s should be written with ::class notation, string found.', $className),
        ];
    }
}
