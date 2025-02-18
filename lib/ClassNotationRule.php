<?php

declare(strict_types=1);

namespace SlamPhpStan;

use Exception;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassLike>
 */
final class ClassNotationRule implements Rule
{
    private ReflectionProvider $broker;

    public function __construct(ReflectionProvider $broker)
    {
        $this->broker = $broker;
    }

    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    /** @return list<RuleError> */
    public function processNode(Node $node, Scope $scope): array
    {
        $nodeIdentifier = $node->name;
        if (null === $nodeIdentifier) {
            return [];
        }
        $name = $nodeIdentifier->name;
        if (\str_starts_with($name, 'AnonymousClass')) {
            return [];
        }
        if (null === $node->namespacedName) {
            return [];
        }

        $messages = [];
        $fqcn     = $node->namespacedName->toString();
        if ($node instanceof Interface_) {
            if (! \preg_match('/Interface$/', $name)) {
                $messages[] = \sprintf('Interface %s should end with "Interface" suffix.', $fqcn);
            }
        } elseif ($node instanceof Trait_) {
            if (! \preg_match('/Trait$/', $name)) {
                $messages[] = \sprintf('Trait %s should end with "Trait" suffix.', $fqcn);
            }
        } else {
            $classRef = $this->broker->getClass($fqcn)->getNativeReflection();

            if ($classRef->isAbstract()) {
                if (\str_contains($name, '_')) {
                    $match = \preg_match('/_Abstract[^_]+$/', $name);
                } else {
                    $match = \preg_match('/^Abstract/', $name);
                }
                if (! $match) {
                    $messages[] = \sprintf('Abstract class %s should start with "Abstract" prefix.', $fqcn);
                }
            }
            if ($classRef->isSubclassOf(Exception::class)) {
                if (! \preg_match('/Exception$/', $name)) {
                    $messages[] = \sprintf('Exception class %s should end with "Exception" suffix.', $fqcn);
                }
            }
        }

        return \array_map(static function (string $message): RuleError {
            return RuleErrorBuilder::message($message)->identifier('classNotation')->build();
        }, $messages);
    }
}
