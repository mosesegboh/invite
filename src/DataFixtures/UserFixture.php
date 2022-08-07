<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Helpers\Constants;

class UserFixture extends Fixture
{
    /**
     * loading User data fixtures for symfony test
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail(Constants::TEST_USER_EMAIL_THREE);
        $user->setPassword(Constants::TEST_USER_PASSWORD);
        $manager->persist($user);

        $manager->flush();
    }
}
