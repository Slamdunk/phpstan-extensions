<?php

declare(strict_types=1);

namespace SlamPhpStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
final class PhpUnitFqcnAnnotationRule implements Rule
{
    private Broker $broker;
    /**
     * @var bool[]
     */
    private array $alreadyParsedDocComments = [];

    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function getNodeType(): string
    {
        return Node::class;
    }

    /**
     * @return RuleError[] errors
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $messages   = [];
        $docComment = $node->getDocComment();
        if (empty($docComment)) {
            return $messages;
        }
        $hash = \sha1(\sprintf(
            '%s:%s:%s:%s',
            $scope->getFile(),
            $docComment->getStartLine(),
            $docComment->getStartFilePos(),
            $docComment->getText()
        ));
        if (isset($this->alreadyParsedDocComments[$hash])) {
            return $messages;
        }
        $this->alreadyParsedDocComments[$hash] = true;

        $lines = \preg_split('/\R/u', $docComment->getText());
        if (false === $lines) {
            return $messages;
        }
        foreach ($lines as $lineNumber => $lineContent) {
            $matches = [];
            if (! \preg_match('/^(?:\s*\*\s*@(?:expectedException|covers|coversDefaultClass|uses)\h+)\\\\?(?<className>\w[^:\s]*)(?:::\S+)?\s*$/u', $lineContent, $matches)) {
                continue;
            }
            if (! $this->broker->hasClass($matches['className'])) {
                $messages[] = RuleErrorBuilder::message(\sprintf('Class %s does not exist.', $matches['className']))->line($docComment->getStartLine() + $lineNumber)->build();
            }
        }

        return $messages;
    }
}
