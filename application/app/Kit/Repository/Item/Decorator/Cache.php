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

namespace App\Kit\Repository\Item\Decorator;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Repository\Item\ItemRepositoryInterface;
use Psr\SimpleCache\CacheInterface;
use Shrikeh\Diving\Kit\Item\ItemSlug;

final class Cache implements ItemRepositoryInterface
{
    /**
     * @var ItemRepositoryInterface
     */
    private ItemRepositoryInterface $itemRepository;

    /**
     * @var CacheInterface
     */
    private CacheInterface $cache;

    /**
     * Cache constructor.
     * @param ItemRepositoryInterface $itemRepository
     * @param CacheInterface $cache
     */
    public function __construct(ItemRepositoryInterface $itemRepository, CacheInterface $cache)
    {
        $this->itemRepository = $itemRepository;
        $this->cache = $cache;
    }

    /**
     * @param ItemSlug $slug
     * @return ItemInterface
     */
    public function fetchBySlug(ItemSlug $slug): ItemInterface
    {
        return $this->itemRepository->fetchBySlug($slug);
    }
}
