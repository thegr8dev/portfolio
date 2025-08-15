<?php

declare(strict_types=1);

namespace PHPStanRules;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

/**
 * @implements Rule<PropertyFetch>
 */
class EloquentPropertyRule implements Rule
{
    private array $ideHelperProperties = [];

    public function __construct()
    {
        $this->loadIdeHelperProperties();
    }

    public function getNodeType(): string
    {
        return PropertyFetch::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node instanceof PropertyFetch) {
            return [];
        }

        if (! $node->name instanceof Identifier) {
            return [];
        }

        $propertyName = $node->name->name;
        $varType = $scope->getType($node->var);

        // Check if this is accessing a property on $this in an Eloquent model
        if (! $this->isEloquentModelAccess($node, $scope)) {
            return [];
        }

        $className = $this->getModelClassNameFromScope($scope);
        if (! $className) {
            return [];
        }

        // Check if property is defined in IDE Helper
        if (! $this->isPropertyDefinedInIdeHelper($className, $propertyName)) {
            return [
                RuleErrorBuilder::message(
                    sprintf(
                        'Property $%s is not defined in IDE Helper for model %s. '.
                        'Run "composer ide-helper" to update model definitions.',
                        $propertyName,
                        $className
                    )
                )->build(),
            ];
        }

        return [];
    }

    private function isEloquentModel($type): bool
    {
        if (! $type instanceof ObjectType) {
            return false;
        }

        $className = $type->getClassName();

        // Check if it's a direct Eloquent model or extends one
        return is_subclass_of($className, 'Illuminate\Database\Eloquent\Model') ||
               $className === 'Illuminate\Database\Eloquent\Model';
    }

    private function getModelClassName($type): ?string
    {
        if (! $type instanceof ObjectType) {
            return null;
        }

        return $type->getClassName();
    }

    private function isEloquentModelAccess(PropertyFetch $node, Scope $scope): bool
    {
        // Check if this is $this->property access within an Eloquent model class
        if ($node->var instanceof \PhpParser\Node\Expr\Variable && $node->var->name === 'this') {
            $classReflection = $scope->getClassReflection();
            if ($classReflection) {
                return $classReflection->isSubclassOf('Illuminate\Database\Eloquent\Model');
            }
        }

        return false;
    }

    private function getModelClassNameFromScope(Scope $scope): ?string
    {
        $classReflection = $scope->getClassReflection();
        if ($classReflection && $classReflection->isSubclassOf('Illuminate\Database\Eloquent\Model')) {
            return $classReflection->getName();
        }

        return null;
    }

    private function loadIdeHelperProperties(): void
    {
        $ideHelperFile = __DIR__.'/../_ide_helper_models.php';

        if (! file_exists($ideHelperFile)) {
            return;
        }

        $content = file_get_contents($ideHelperFile);
        if (! $content) {
            return;
        }

        // Parse the IDE Helper file to extract property definitions
        preg_match_all(
            '/namespace\s+([^{]+)\s*{\s*\/\*\*(.*?)\*\/\s*.*?class\s+(\w+)/s',
            $content,
            $matches,
            PREG_SET_ORDER
        );

        foreach ($matches as $match) {
            $namespace = trim($match[1]);
            $docComment = $match[2];
            $className = $match[3];

            // Remove "IdeHelper" prefix to get the actual model name
            $modelName = str_replace('IdeHelper', '', $className);
            $fullClassName = $namespace.'\\'.$modelName;

            // Extract @property annotations
            preg_match_all('/@property(?:-read)?\s+[^\s]+\s+\$(\w+)/', $docComment, $propertyMatches);

            if (! empty($propertyMatches[1])) {
                $this->ideHelperProperties[$fullClassName] = $propertyMatches[1];
            }
        }
    }

    private function isPropertyDefinedInIdeHelper(string $className, string $propertyName): bool
    {
        // Skip common framework properties that are always available
        $frameworkProperties = [
            'attributes', 'original', 'changes', 'casts', 'dates', 'dateFormat',
            'appends', 'dispatchesEvents', 'observables', 'relations', 'touches',
            'timestamps', 'primaryKey', 'keyType', 'incrementing', 'with', 'withCount',
            'exists', 'wasRecentlyCreated', 'connection', 'table', 'fillable', 'guarded',
            'hidden', 'visible', 'perPage',
        ];

        if (in_array($propertyName, $frameworkProperties)) {
            return true;
        }

        return isset($this->ideHelperProperties[$className]) &&
               in_array($propertyName, $this->ideHelperProperties[$className]);
    }
}
