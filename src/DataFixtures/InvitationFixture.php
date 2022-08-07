<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Invitations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Helpers\Constants;

class InvitationFixture extends Fixture
{
    private $em;
    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;
    }

     /**
     * loading Invitations data fixtures for symfony test
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $invitation = new Invitations();
        $invitation->setSubject(Constants::TEST_SUBJECT);
        $invitation->setMessage(Constants::TEST_MESSAGE);
        $invitation->setStatus(Constants::STATUS);
        $invitation->setSenderId($this->persistUserSender());
        $invitation->setReceiverId($this->persistUser());
        $invitation->getAcceptance(Constants::ACCEPTED);
        $this->em->persist($invitation);

        $this->em->flush();
    }

     /**
     * loading User instance for relationship data fixtures for symfony test
     *
     * @return User
     */
    private function persistUser(): User
    {
        $user = new User();
        $user->setEmail(Constants::TEST_USER_EMAIL_TWO);
        $user->setPassword(Constants::TEST_USER_PASSWORD);
        return $user;
    }

     /**
     * loading User instance for relationship data fixtures for symfony test
     *
     * @return User
     */
    private function persistUserSender(): User
    {
        $user = new User();
        $user->setEmail(Constants::TEST_USER_EMAIL);
        $user->setPassword(Constants::TEST_USER_PASSWORD);
        return $user;
    }
}
