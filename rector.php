<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\Property\AddPropertyTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSets([
        // Apply PHP Level sets
        LevelSetList::UP_TO_PHP_82,
        // Apply PHPUnit-specific sets,
        PHPUnitSetList::PHPUNIT_80,
        PHPUnitSetList::PHPUNIT_90,
        // Apply PHP Refactoring Sets
        SetList::CODE_QUALITY,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
        SetList::CARBON,
    ])
    ->withSkip([
        ClassOnObjectRector::class
    ])
    ->withTypeCoverageLevel(50)
    ->withDeadCodeLevel(20)
    ->withImportNames()
    ->withRules([
        // PHP CQ rules
        AddPropertyTypeDeclarationRector::class,
        AddParamTypeDeclarationRector::class,
        AddReturnTypeDeclarationRector::class,
        DeclareStrictTypesRector::class,
    ]);
