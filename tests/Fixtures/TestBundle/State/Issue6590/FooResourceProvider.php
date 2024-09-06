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

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Tests\Fixtures\TestBundle\ApiResource\Issue6590\BarResource;
use ApiPlatform\Tests\Fixtures\TestBundle\ApiResource\Issue6590\FooResource;
use ApiPlatform\Tests\Fixtures\TestBundle\Entity\Issue6590\Foo;

class FooResourceProvider implements ProviderInterface
{
    public function __construct(private readonly ProviderInterface $itemProvider, private readonly ProviderInterface $collectionProvider)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof Get) {
            /**
             * @var Foo $entity
             */
            $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

            return $this->getResource($entity);
        }
        $resources = [];
        $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);
        foreach ($entities as $entity) {
            $resources[] = $this->getResource($entity);
        }

        return $resources;
    }

    protected function getResource(Foo $entity): FooResource
    {
        $resource = new FooResource();
        $resource->id = $entity->getId();

        foreach ($entity->getBars() as $barEntity) {
            $barResource = new BarResource();
            $barResource->id = $barEntity->getId();
            $barResource->name = $barEntity->getName();
            $resource->bars[] = $barResource;
        }

        return $resource;
    }
}
