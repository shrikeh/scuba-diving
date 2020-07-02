<?php

namespace Tests\Integration;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\ItemDetailQueryBusInterface;
use App\Kit\Query\Result\ItemDetail;
use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Tests\Codecept\Module\Symfony;

final class MessageBusTest extends Unit
{
    public function testItReturnsTheItemDetails(): void
    {
        $slug = 'othree-drysuit';
        $container = $this->getContainer();
        $itemHttpClient = $this->prophesize(HttpClientInterface::class);
        $manufacturerHttpClient = $this->prophesize(HttpClientInterface::class);
        $itemResponse = $this->prophesize(ResponseInterface::class);
        $manufacturerResponse = $this->prophesize(ResponseInterface::class);

        $itemResponse->getContent()->willReturn('{ "name": "foo" }');
        $manufacturerResponse->getContent()->willReturn('{ "name": "bar" }');

        $itemHttpClient->request('GET', Argument::any())->willReturn($itemResponse->reveal());
        $manufacturerHttpClient->request('GET', Argument::any())->willReturn($manufacturerResponse->reveal());

        $container->set('app.kit.repository.item.client', $itemHttpClient->reveal());
        $container->set('app.kit.repository.manufacturer.client', $manufacturerHttpClient->reveal());

        $messageBus = $container->get(ItemDetailQueryBusInterface::class);

        $queryKitItemDetail = new QueryKitItemDetail($slug);

        $itemDetailResult = $messageBus->queryKitItemDetail($queryKitItemDetail);
        $this->assertInstanceOf(ItemDetail::class, $itemDetailResult);
    }

    /**
     * @return ContainerInterface
     * @throws ModuleException
     */
    private function getContainer(): ContainerInterface
    {
        return $this->getModule(Symfony::class)->_getContainer();
    }
}
