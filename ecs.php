<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff;
use SlevomatCodingStandard\Sniffs\Variables\UselessVariableSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\MultipleUsesPerLineSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedGlobalConstantsSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedGlobalFunctionsSniff;
use SlevomatCodingStandard\Sniffs\Operators\DisallowEqualOperatorsSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\AssignmentInConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowYodaComparisonSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireNullCoalesceEqualOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireNullSafeObjectOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowTrailingMultiLineTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\Arrays\TrailingArrayCommaSniff;
use SlevomatCodingStandard\Sniffs\Arrays\MultiLineArrayEndBracketPlacementSniff;
use SlevomatCodingStandard\Sniffs\Arrays\SingleLineArrayWhitespaceSniff;
use SlevomatCodingStandard\Sniffs\PHP\ShortListSniff;
use SlevomatCodingStandard\Sniffs\PHP\UselessSemicolonSniff;
use SlevomatCodingStandard\Sniffs\PHP\RequireNowdocSniff;
use SlevomatCodingStandard\Sniffs\PHP\DisallowDirectMagicInvokeCallSniff;
use SlevomatCodingStandard\Sniffs\PHP\RequireExplicitAssertionSniff;
use SlevomatCodingStandard\Sniffs\Commenting\EmptyCommentSniff;
use SlevomatCodingStandard\Sniffs\Commenting\AnnotationNameSniff;
use SlevomatCodingStandard\Sniffs\Classes\ModernClassNameReferenceSniff;

return function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // this way you add a single rule
    $ecsConfig->rules([
        NoUnusedImportsFixer::class,
        GlobalNamespaceImportFixer::class,
        UnusedVariableSniff::class,
        UselessVariableSniff::class,
        MultipleUsesPerLineSniff::class,
        FullyQualifiedGlobalConstantsSniff::class,
        FullyQualifiedGlobalFunctionsSniff::class,
        DisallowEqualOperatorsSniff::class,
        AssignmentInConditionSniff::class,
        DisallowYodaComparisonSniff::class,
        RequireNullCoalesceEqualOperatorSniff::class,
        RequireNullSafeObjectOperatorSniff::class,
        DisallowTrailingMultiLineTernaryOperatorSniff::class,
        TrailingArrayCommaSniff::class,
        MultiLineArrayEndBracketPlacementSniff::class,
        SingleLineArrayWhitespaceSniff::class,
        ShortListSniff::class,
        UselessSemicolonSniff::class,
        RequireNowdocSniff::class,
        DisallowDirectMagicInvokeCallSniff::class,
        RequireExplicitAssertionSniff::class,
        EmptyCommentSniff::class,
        AnnotationNameSniff::class,
        ModernClassNameReferenceSniff::class,
    ]);

    // this way you can add sets - group of rules
    $ecsConfig->sets([
        // run and fix, one by one
        SetList::SPACES,
        SetList::ARRAY,
        SetList::DOCBLOCK,
        SetList::NAMESPACES,
        SetList::COMMENTS,
        SetList::PSR_12,
    ]);
};
