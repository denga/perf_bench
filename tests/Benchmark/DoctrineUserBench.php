<?php

declare(strict_types=1);

namespace App\Test\Benchmark;

use App\Repository\UserRepository;
use PhpBench\Attributes\Revs;

class DoctrineUserBench
{
    private UserRepository $repository;

    public function __construct()
    {
        $em = getEntityManager();

        dropSchema($em);
        createSchema($em);
        loadFixtures($em);

        $this->repository = new UserRepository($em);
    }

    #[Revs(1000)]
    public function benchSQLAssoc(): void
    {
        $this->repository->fetchSQLAssoc();
    }

    #[Revs(1000)]
    public function benchSQLConstructorModels(): void
    {
        $this->repository->fetchSQLConstructorModels();
    }

    #[Revs(1000)]
    public function benchSQLSetterModels(): void
    {
        $this->repository->fetchSQLSetterModels();
    }

    #[Revs(1000)]
    public function benchDQLArray(): void
    {
        $this->repository->fetchDQLArray();
    }

    #[Revs(1000)]
    public function benchModels(): void
    {
        $this->repository->fetchModels();
    }

    #[Revs(1000)]
    public function benchFindAll(): void
    {
        $this->repository->fetchEntities();
    }

    #[Revs(1000)]
    public function benchEntitiesWithQueryBuilder(): void
    {
        $this->repository->fetchEntitiesWithQueryBuilder();
    }
}
