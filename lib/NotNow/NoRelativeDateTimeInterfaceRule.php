<?php

declare(strict_types=1);

namespace SlamPhpStan\NotNow;

use DateTimeInterface;
use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\TypeWithClassName;

/**
 * @implements Rule<New_>
 */
final class NoRelativeDateTimeInterfaceRule implements Rule
{
    public function getNodeType(): string
    {
        return New_::class;
    }

    /** @return list<RuleError> */
    public function processNode(Node $node, Scope $scope): array
    {
        $type = $scope->getType($node);
        if (! $type instanceof TypeWithClassName) {
            return [];
        }

        if (null === $type->getAncestorWithClassName(DateTimeInterface::class)) {
            return [];
        }

        $args = $node->getArgs();

        if (0 === \count($args)) {
            return [RuleErrorBuilder::message(\sprintf(
                'Instantiating %s without the first argument is forbidden, rely on a clock abstraction like lcobucci/clock',
                DateTimeInterface::class,
            ))->identifier('newdate.implicitTime.forbidden')->build()];
        }

        $argType = $scope->getType($args[0]->value);
        if (! $argType instanceof ConstantScalarType) {
            return [];
        }

        $value = $argType->getValue();
        if (! \is_string($value) || ! ForbiddenRelativeFormats::isForbidden($value)) {
            return [];
        }

        return [RuleErrorBuilder::message(\sprintf(
            'Instantiating %s with relative datetime "%s" is forbidden, rely on a clock abstraction like lcobucci/clock',
            DateTimeInterface::class,
            $value,
        ))->identifier('newdate.relativeTime.forbidden')->build()];
    }
}
