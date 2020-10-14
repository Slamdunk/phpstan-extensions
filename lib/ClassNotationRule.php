<?php

declare(strict_types=1);

namespace SlamPhpStan;

use Exception;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<ClassLike>
 */
final class ClassNotationRule implements Rule
{
    private Broker $broker;

    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    /**
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages       = [];
        $nodeIdentifier = $node->name;
        if (null === $nodeIdentifier) {
            return $messages;
        }
        $name = $nodeIdentifier->name;
        if (0 === \strpos($name, 'AnonymousClass')) {
            return $messages;
        }

        $fqcn = $node->namespacedName->toString();
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
                if (false !== \strpos($name, '_')) {
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

        return $messages;
    }
}
