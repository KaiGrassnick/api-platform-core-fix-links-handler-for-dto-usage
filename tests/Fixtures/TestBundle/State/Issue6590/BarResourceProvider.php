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

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Tests\Fixtures\TestBundle\ApiResource\Issue6590\BarResource;
use ApiPlatform\Tests\Fixtures\TestBundle\Entity\Issue6590\Bar;

class BarResourceProvider implements ProviderInterface
{
    public function __construct(private readonly ProviderInterface $itemProvider)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /**
         * @var Bar $entity
         */
        $entity         = $this->itemProvider->provide($operation, $uriVariables, $context);
        $resource       = new BarResource();
        $resource->id   = $entity->getId();
        $resource->name = $entity->getName();

        return $resource;
    }
}
