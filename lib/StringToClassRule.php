<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<String_>
 */
final class StringToClassRule implements Rule
{
    private ReflectionProvider $broker;

    public function __construct(ReflectionProvider $broker)
    {
        $this->broker = $broker;
    }

    public function getNodeType(): string
    {
        return String_::class;
    }

    /** @return list<RuleError> */
    public function processNode(Node $node, Scope $scope): array
    {
        $className = $node->value;
        if (isset($className[0]) && '\\' === $className[0]) {
            $className = \substr($className, 1);
        }
        if (! \preg_match('/^\w.+\w$/u', $className)) {
            return [];
        }
        if (! $this->broker->hasClass($className)) {
            return [];
        }

        $classRef = $this->broker->getClass($className)->getNativeReflection();
        if ($classRef->isInternal() && $classRef->getName() !== $className) {
            return [];
        }

        return [RuleErrorBuilder::message(\sprintf(
            'Class %s should be written with ::class notation, string found.',
            $className,
        ))->identifier('stringToClassNotation')->build()];
    }
}
