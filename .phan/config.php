<?php
/*
 * This file is part of the Diving Site package.
 *
 * (c) Barney Hanlon <barney@shrikeh.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

die(var_dump($_ENV));

/**
 * Workaround so that phan plugins work in all environments
 * @return Generator
 * @throws \Safe\Exceptions\StringsException
 */
function fetch_plugin_paths(): Generator
{
    $path = dirname(__DIR__) . '/vendor/phan/phan/.phan/plugins/';
    $plugins = [
        'AlwaysReturnPlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'DuplicateExpressionPlugin',
        'UnreachableCodePlugin',
        'UseReturnValuePlugin',
        'EmptyStatementListPlugin',
        'LoopVariableReusePlugin',
        'InvokePHPNativeSyntaxCheckPlugin',
        'WhitespacePlugin',
    ];

    foreach ($plugins as $plugin) {
        yield \Safe\sprintf(
            '%s/%s.php',
            $path,
            $plugin
        );
    }
}

function fetch_plugins(): Generator
{
    foreach (fetch_plugin_paths() as $pluginPath) {

    }
}

return [
    'backward_compatibility_checks' => false,
    'target_php_version' => null,
    'directory_list' => [
        'application/app/',
        'application/src/',
        'vendor/psr',
        'vendor/ramsey/uuid',
        'vendor/symfony',
        'vendor/thecodingmachine/safe',
    ],
    'exclude_analysis_directory_list' => [
        'vendor/',
        'tests/',
    ],
    'exclude_file_regex' => '@^vendor/.*/(tests|Tests)/@',
    'plugins' => iterator_to_array(fetch_plugins()),
    'plugin_config' => [
        'php_native_syntax_check_max_processes' => 4,
    ],
];
