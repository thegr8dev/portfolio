<?php

declare(strict_types=1);

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Config\RectorConfig;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class CleanIdeHelperDocBlocksRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Clean IDE Helper DocBlocks, keeping only @mixin annotations', [
            new CodeSample(
                <<<'CODE_SAMPLE'
/**
 * @property int $id
 * @property string $name
 * @method static Builder query()
 * @mixin \Eloquent
 * @mixin IdeHelperUser
 */
class User extends Model
{
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
/**
 * @mixin IdeHelperUser
 */
class User extends Model
{
}
CODE_SAMPLE
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param  Class_  $node
     */
    public function refactor(Node $node): ?Node
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return null;
        }

        $text = $docComment->getText();

        // Check if this looks like an IDE Helper generated DocBlock
        if (! $this->isIdeHelperDocBlock($text)) {
            return null;
        }

        // Extract only @mixin annotations (excluding @mixin \Eloquent)
        $mixinLines = [];
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            if (preg_match('/@mixin\s+(?!\\\\Eloquent\s*$)(.+)/', $line, $matches)) {
                $mixinLines[] = ' * @mixin '.trim($matches[1]);
            }
        }

        if (empty($mixinLines)) {
            // Remove the entire DocBlock if no relevant @mixin found
            $node->setDocComment(null);

            return $node;
        }

        // Create new clean DocBlock with only the relevant @mixin
        $newDocBlock = "/**\n".implode("\n", $mixinLines)."\n */";
        $node->setDocComment(new \PhpParser\Comment\Doc($newDocBlock));

        return $node;
    }

    private function isIdeHelperDocBlock(string $text): bool
    {
        // Check for typical IDE Helper patterns
        return
            str_contains($text, '@property') ||
            str_contains($text, '@method static') ||
            (str_contains($text, '@mixin') && (
                str_contains($text, '@property') ||
                str_contains($text, '@method')
            ));
    }
}

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app/Models',
    ])
    ->withRules([
        CleanIdeHelperDocBlocksRector::class,
    ]);
