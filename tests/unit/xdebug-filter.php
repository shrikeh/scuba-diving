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

if (!function_exists('xdebug_set_filter')) {
    return;
}

require_once dirname(__DIR__) . '/constants.php';

xdebug_set_filter(
    XDEBUG_FILTER_CODE_COVERAGE,
    XDEBUG_PATH_WHITELIST,
    [
        sprintf(APPLICATION_DIR, 'app'),
        sprintf(APPLICATION_DIR, 'src'),
    ]
);
