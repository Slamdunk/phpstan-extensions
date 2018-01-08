<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;

final class ClassNotationRule implements Rule
{
    private $broker;

    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    /**
     * @param \PhpParser\Node\Stmt\ClassLike $node
     * @param \PHPStan\Analyser\Scope        $scope
     *
     * @return string[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages = [];
        $name = $node->name;
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
            if ($classRef->isSubclassOf(\Exception::class)) {
                if (! \preg_match('/Exception$/', $name)) {
                    $messages[] = \sprintf('Exception class %s should end with "Exception" suffix.', $fqcn);
                }
            }
        }

        return $messages;
    }
}
