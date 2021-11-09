<?php

declare(strict_types=1);

namespace SlamPhpStan\NotNow;

use DateTimeInterface;
use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\ObjectType;

/**
 * @implements Rule<New_>
 */
final class NoRelativeDateTimeInterfaceRule implements Rule
{
    public function getNodeType(): string
    {
        return New_::class;
    }

    /**
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $type = $scope->getType($node);
        if (! $type instanceof ObjectType) {
            return [];
        }

        if (null === $type->getAncestorWithClassName(DateTimeInterface::class)) {
            return [];
        }

        $args = $node->getArgs();

        if (0 === \count($args)) {
            return [
                \sprintf(
                    'Instantiating %s without the first argument is forbidden, rely on a clock abstraction like lcobucci/clock',
                    DateTimeInterface::class
                ),
            ];
        }

        $argType = $scope->getType($args[0]->value);
        if (! $argType instanceof ConstantScalarType) {
            return [];
        }

        $value = $argType->getValue();
        if (! \is_string($value) || ! ForbiddenRelativeFormats::isForbidden($value)) {
            return [];
        }

        return [
            \sprintf(
                'Instantiating %s with relative datetime "%s" is forbidden, rely on a clock abstraction like lcobucci/clock',
                DateTimeInterface::class,
                $value
            ),
        ];
    }
}
