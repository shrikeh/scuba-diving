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

namespace Shrikeh\Diving\Kit;

use Psr\Http\Message\UriInterface;

final class Manufacturer
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var UriInterface|null
     */
    private ?UriInterface $website;
    /**
     * @var UriInterface
     */
    private ?UriInterface $logo;

    /**
     * Manufacturer constructor.
     *
     * @param string            $name
     * @param UriInterface|null $logo
     * @param UriInterface|null $website
     */
    public function __construct(string $name, UriInterface $logo = null, UriInterface $website = null)
    {
        $this->name = $name;
        $this->website = $website;
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UriInterface|null
     */
    public function getWebsite(): ?UriInterface
    {
        return $this->website;
    }

    /**
     * @return UriInterface
     */
    public function getLogo(): ?UriInterface
    {
        return $this->logo;
    }
}
