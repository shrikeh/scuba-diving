<?php

declare(strict_types=1);

use Tests\Constants;

if (file_exists(Constants::appConfigDir() . '/bootstrap.php')) {
    require Constants::appConfigDir() . '/bootstrap.php';
}
