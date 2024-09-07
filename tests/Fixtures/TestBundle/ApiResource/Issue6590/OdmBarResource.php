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

namespace ApiPlatform\Tests\Fixtures\TestBundle\ApiResource\Issue6590;

use ApiPlatform\Doctrine\Odm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GraphQl\Query;
use ApiPlatform\Metadata\GraphQl\QueryCollection;
use ApiPlatform\Tests\Fixtures\TestBundle\Document\Issue6590\Bar;
use ApiPlatform\Tests\Fixtures\TestBundle\State\Issue6590\BarResourceProvider;

#[ApiResource(
    shortName: 'Issue6590OdmBar',
    operations: [],
    graphQlOperations: [
        new Query(),
        new QueryCollection(),
    ],
    provider: BarResourceProvider::class,
    stateOptions: new Options(documentClass: Bar::class)
)]
class OdmBarResource
{
    #[ApiProperty(identifier: true)]
    public int $id;

    public string $name;
}
