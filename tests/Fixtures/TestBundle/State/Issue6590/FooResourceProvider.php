<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\Tests\Fixtures\TestBundle\State\Issue6590;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Tests\Fixtures\TestBundle\ApiResource\Issue6590\OdmBarResource;
use ApiPlatform\Tests\Fixtures\TestBundle\ApiResource\Issue6590\OdmFooResource;
use ApiPlatform\Tests\Fixtures\TestBundle\ApiResource\Issue6590\OrmBarResource;
use ApiPlatform\Tests\Fixtures\TestBundle\ApiResource\Issue6590\OrmFooResource;
use ApiPlatform\Tests\Fixtures\TestBundle\Document\Issue6590\Foo as FooDocument;
use ApiPlatform\Tests\Fixtures\TestBundle\Entity\Issue6590\Foo as FooEntity;

class FooResourceProvider implements ProviderInterface
{
    public function __construct(
        private readonly ProviderInterface $itemProvider,
        private readonly ProviderInterface $collectionProvider,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);
            \assert($entities instanceof Paginator);

            $resources = [];
            foreach ($entities as $entity) {
                $resources[] = $this->getResource($entity);
            }

            return new TraversablePaginator(
                new \ArrayIterator($resources),
                $entities->getCurrentPage(),
                $entities->getItemsPerPage(),
                $entities->getTotalItems()
            );
        }

        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        return $this->getResource($entity);
    }

    protected function getResource(FooEntity|FooDocument $entity): OrmFooResource|OdmFooResource
    {
        $resource = ($entity instanceof FooEntity) ? new OrmFooResource() : new OdmFooResource();
        $resource->id = $entity->getId();

        foreach ($entity->getBars() as $barEntity) {
            $barResource = ($entity instanceof FooEntity) ? new OrmBarResource() : new OdmBarResource();
            $barResource->id = $barEntity->getId();
            $barResource->name = $barEntity->getName();
            $resource->bars[] = $barResource;
        }

        return $resource;
    }
}
