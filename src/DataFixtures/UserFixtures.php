<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct (UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setEmail('bob@bob.com');
        $user->setRoles(["bla"]);

        // encode password
        $encodePassword = $this->encoder->encodePassword($user, 123);
        $user->setPassword($encodePassword);

        $manager->persist($user);

        $manager->flush();
    }
}
