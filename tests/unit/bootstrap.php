<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/constants.php';

require VENDOR_DIR . '/autoload.php';

if (file_exists(APP_CONFIG_DIR . '/bootstrap.php')) {
    require APP_CONFIG_DIR . '/bootstrap.php';
}
