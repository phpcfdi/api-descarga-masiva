<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenFinalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenPrivateMethods;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenTraits;
use NunoMaduro\PhpInsights\Domain\Metrics\Architecture\Classes;
use NunoMaduro\PhpInsights\Domain\Metrics\Style\Style;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowShortTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\Functions\FunctionLengthSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\ReferenceUsedNamesOnlySniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowMixedTypeHintSniff;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal"
    |
    */

    'preset' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | IDE
    |--------------------------------------------------------------------------
    |
    | These options allow adding hyperlinks in your terminal to quickly open
    | files in your favorite IDE while browsing your PhpInsights report.
    |
    | Supported: "textmate", "macvim", "emacs", "sublime", "phpstorm",
    | "atom", "vscode".
    |
    | If you have another IDE that is not in this list but which provide an
    | url-handler, you could fill this config with a pattern like this:
    |
    | myide://open?url=file://%f&line=%l
    |
    */

    'ide' => null,

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind that all added `Insights` must belong to a specific `Metric`.
    |
    */

    'exclude' => [
        'app/Http/Kernel.php',
        'app/Console/Kernel.php',
    ],

    'add' => [
        Classes::class => [
            ForbiddenFinalClasses::class,
        ],
        Style::class => [
            ReferenceUsedNamesOnlySniff::class
        ]
    ],

    'remove' => [
        DisallowMixedTypeHintSniff::class,
        DisallowShortTernaryOperatorSniff::class,
        ForbiddenNormalClasses::class,
        ForbiddenPublicPropertySniff::class,
        ForbiddenTraits::class,
        LineLengthSniff::class, // check by php_codesniffer
    ],

    'config' => [
        ForbiddenPrivateMethods::class => [
            'title' => 'The usage of private methods is not idiomatic in Laravel.',
        ],
        CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 10,
        ],
        FunctionLengthSniff::class => [
            'maxLinesLength' => 25,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    |
    | Here you may define a level you want to reach per `Insights` category.
    | When a score is lower than the minimum level defined, then an error
    | code will be returned. This is optional and individually defined.
    |
    */

    'requirements' => [
        'min-quality' => 0,
        'min-complexity' => 0,
        'min-architecture' => 0,
        'min-style' => 100,
        'disable-security-check' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analysis. This is optional, don't provide it and the tool will guess
    | the max core number available. This accepts null value or integer > 0.
    |
    */

    'threads' => null,

];
