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

namespace App\Kit\Repository\ResolverFactory;

use App\Kit\Resolver\ResolverInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ResolverFactoryInterface
{
    public function createResolver(ResponseInterface $response, UuidInterface $uuid): ResolverInterface;
}
