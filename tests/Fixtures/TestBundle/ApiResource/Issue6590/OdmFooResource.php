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
use ApiPlatform\Tests\Fixtures\TestBundle\Document\Issue6590\Foo;
use ApiPlatform\Tests\Fixtures\TestBundle\State\Issue6590\FooResourceProvider;

#[ApiResource(
    shortName: 'Issue6590OdmFoo',
    operations: [],
    graphQlOperations: [
        new Query(),
        new QueryCollection(),
    ],
    provider: FooResourceProvider::class,
    stateOptions: new Options(documentClass: Foo::class)
)]
class OdmFooResource
{
    #[ApiProperty(identifier: true)]
    public int $id;

    /**
     * @var OdmBarResource[]
     */
    public array $bars;

    public function addBar(OdmBarResource $bar): void
    {
        $this->bars[] = $bar;
    }

    public function removeBar(OdmBarResource $bar): void
    {
        unset($this->bars[array_search($bar, $this->bars, true)]);
    }
}
