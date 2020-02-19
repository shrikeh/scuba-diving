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

namespace App\Kit\Repository\Item\ModelFactory;

use App\Kit\Model\Item\Decorator\ClosureResolver;
use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\ResolverFactory\ResolverFactoryInterface;
use App\Kit\Resolver\ResolverInterface;
use Ramsey\Uuid\UuidInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ItemResolver implements ItemModelFactoryInterface
{
    /**
     * @var ResolverFactoryInterface
     */
    private ResolverFactoryInterface $resolverFactory;

    /**
     * ItemResolver constructor.
     *
     * @param ResolverFactoryInterface $resolverFactory
     */
    public function __construct(ResolverFactoryInterface $resolverFactory)
    {
        $this->resolverFactory = $resolverFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function createItemFromResponse(ResponseInterface $response, ItemSlug $slug): ItemInterface
    {
        return ClosureResolver::create($this->createResolverClosure($response, $slug->toUuid()));
    }

    /**
     * @param ResponseInterface $response
     * @param UuidInterface     $uuid
     *
     * @return ResolverInterface
     */
    private function createResolverClosure(ResponseInterface $response, UuidInterface $uuid): ResolverInterface
    {
        return $this->resolverFactory->createResolver($response, $uuid);
    }
}
