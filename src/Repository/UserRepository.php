<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Model\UserModel;
use Doctrine\ORM\EntityManager;

class UserRepository
{
    public function __construct(
        private readonly EntityManager $em
    ) {}

    public function fetchSQLAssoc(): array
    {
        $result = $this->em->getConnection()->executeQuery("SELECT * FROM User");
        return $result->fetchAllAssociative();
    }

    public function fetchSQLConstructorModels(): array
    {
        $result = $this->em->getConnection()->executeQuery("SELECT * FROM User");
        $users = $result->fetchAllAssociative();

        return array_map(static fn(array $user) => new UserModel(
            $user['id'],
            $user['firstName'],
            $user['lastName'],
            $user['email'],
        ), $users);
    }

    public function fetchSQLSetterModels(): array
    {
        $result = $this->em->getConnection()->executeQuery("SELECT * FROM User");
        $users = $result->fetchAllAssociative();

        return array_map(static fn(array $user) => (new User())
            ->setFirstName($user['firstName'])
            ->setLastName($user['lastName'])
            ->setEmail($user['email'])
        , $users);
    }

    public function fetchDQLArray(): array
    {
        return $this->em
            ->createQuery("SELECT u FROM App\Entity\User u")
            ->getArrayResult();
    }

    public function fetchModels(): array
    {
        return $this->em
            ->createQuery("SELECT NEW App\Model\UserModel(u.id, u.firstName, u.lastName, u.email) FROM App\Entity\User u")
            ->getArrayResult();
    }

    public function fetchEntities(): array
    {
        return $this->em
            ->getRepository(User::class)
            ->findAll();
    }

    public function fetchEntitiesWithQueryBuilder(): array
    {
        return $this->em
            ->getRepository(User::class)
            ->createQueryBuilder('u')
            ->getQuery()
            ->getResult();
    }
}
