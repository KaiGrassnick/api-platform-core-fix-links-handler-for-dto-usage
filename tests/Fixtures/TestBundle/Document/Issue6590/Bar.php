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

namespace ApiPlatform\Tests\Fixtures\TestBundle\Document\Issue6590;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document()]
class Bar
{
    #[ODM\Id(type: 'int', strategy: 'INCREMENT')]
    private int $id;

    #[ODM\Field]
    private string $name;

    #[ODM\ReferenceOne(nullable: true, storeAs: 'id', targetDocument: Foo::class)]
    private ?Foo $foo = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getFoo(): ?Foo
    {
        return $this->foo;
    }

    public function setFoo(?Foo $foo): self
    {
        $this->foo = $foo;
        return $this;
    }
}
