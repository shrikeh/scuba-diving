<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__) . '/constants.php';

require VENDOR_DIR . '/autoload.php';

if (file_exists(APP_CONFIG_DIR . '/bootstrap.php')) {
    require APP_CONFIG_DIR . '/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}
