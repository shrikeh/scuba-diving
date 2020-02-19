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

namespace App\Kit\Query\Result;

use App\Kit\Model\Item\ItemInterface;
use App\Kit\Model\Manufacturer\ManufacturerInterface;
use Shrikeh\Diving\Kit\Item;
use Shrikeh\Diving\Kit\Manufacturer;

final class SimpleItem implements Item
{
    private ItemInterface $item;

    private ManufacturerInterface $manufacturer;

    /**
     * SimpleItem constructor.
     *
     * @param ItemInterface         $item
     * @param ManufacturerInterface $manufacturer
     */
    public function __construct(ItemInterface $item, ManufacturerInterface $manufacturer)
    {
        $this->item = $item;
        $this->manufacturer = $manufacturer;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->item->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getManufacturerName(): string
    {
        return $this->manufacturer->getName();
    }
}
