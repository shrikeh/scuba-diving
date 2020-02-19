<?php

namespace Tests\Integration;

use App\Kit\Message\QueryKitItemDetail;
use App\Kit\Query\Bus\ItemDetailQueryBusInterface;
use Codeception\Test\Unit;
use Symfony\Component\DependencyInjection\Container;

final class MessageBusTest extends Unit
{
    public function testItReturnsTheItemDetails(): void
    {
        $messageBus = $this->getMessageBus();
        $slug = 'othree-drysuit';
        $queryKitItemDetail = new QueryKitItemDetail($slug);

        $itemDetailResult = $messageBus->queryKitItemDetail($queryKitItemDetail);
    }

    /**
     * @throws \Codeception\Exception\ModuleException
     *
     * @return ItemDetailQueryBusInterface
     */
    private function getMessageBus(): ItemDetailQueryBusInterface
    {
        /** @var Container $container */
        $container = $this->getModule('Symfony')->_getContainer();

        return $container->get(ItemDetailQueryBusInterface::class);
    }
}
