<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserDataLoader implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 1000) as $num) {
            $user = new User();
            $user->setFirstName(sprintf('First Name %d', $num));
            $user->setLastName(sprintf('Last Name %d', $num));
            $user->setEmail(sprintf('email%d@example.com', $num));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
