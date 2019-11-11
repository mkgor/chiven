<?php

use Chiven\Http\Repository\AbstractRepository;

class AbstractRepositoryTest extends \PHPUnit\Framework\TestCase
{
    private $repository;

    public function setUp()
    {
        $this->repository = new \Chiven\Http\Repository\HeaderRepository();
    }

    public function testInsert()
    {
        $this->repository->insert(new \Chiven\Http\Entity\Header('X-Test-Header', 23));
        $this->repository->insert(new \Chiven\Http\Entity\Header('X-Test-Header', 23));

        $this->assertInstanceOf(\Chiven\Http\Entity\Header::class, $this->repository->findLast());
    }

    public function testRemove()
    {
        $this->repository->insert(new \Chiven\Http\Entity\Header('X-Test-Header', true));

        $this->assertInstanceOf(\Chiven\Http\Entity\Header::class, $this->repository->findFirst());
        $this->assertCount(1, $this->repository->findAll());

        $this->repository->remove('name', 'X-Test-Header');
        $this->assertFalse($this->repository->findFirst());
    }

    public function testFindAll()
    {
        $this->repository->insert(new \Chiven\Http\Entity\Header('X-Test-Header', true));
        $this->repository->insert(new \Chiven\Http\Entity\Header('X-Test-Header-2', true));

        $this->assertCount(2, $this->repository->findAll());
    }

    public function testFindBy()
    {
        $this->repository->insert(new \Chiven\Http\Entity\Header('X-Test-Header', true));

        $this->assertEquals('X-Test-Header', $this->repository->findBy('name', 'X-Test-Header')->getName());
    }
}
