<?php

declare(strict_types=1);

namespace Tests\Behat\Context\Kit;

use Behat\Behat\Context\Context;

final class ServiceContext implements Context
{
    /** @var string */
    private string $kit;

    /** @var string */
    private string $manufacturer;

    /** @var string */
    private string $uri ;

    /**
     * @Given that I have a :kit
     * @param string $kit
     */
    public function thatIHaveA(string $kit): void
    {
        $this->kit = $kit;
    }

    /**
     * @Given the manufacturer is :manufacturer
     * @param string $manufacturer
     */
    public function theManufacturerIs(string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @Given the product URI is :uri
     * @param string $uri
     */
    public function theProductUriIs(string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * @Given the product has a photo
     */
    public function theProductHasAPhoto(): void
    {
        throw new PendingException();
    }

    /**
     * @When I look at the item of kit
     */
    public function iLookAtTheItemOfKit(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I see all the information
     */
    public function iSeeAllTheInformation(): void
    {
        throw new PendingException();
    }
}
