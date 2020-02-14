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

namespace App\Api;

use App\Kit\Model\ModelInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ResponseParserInterface
{
    /**
     * @param ResponseInterface $response
     * @return ModelInterface
     */
    public function parse(ResponseInterface $response): ModelInterface;
}
