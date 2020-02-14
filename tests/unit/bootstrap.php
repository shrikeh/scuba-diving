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

require_once dirname(__DIR__) . '/constants.php';

require VENDOR_DIR . '/autoload.php';

if (file_exists(APP_CONFIG_DIR . '/bootstrap.php')) {
    require APP_CONFIG_DIR . '/bootstrap.php';
}
