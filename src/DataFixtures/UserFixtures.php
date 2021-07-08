<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public const USER_BOB_ADMIN = 'bob@bob.com';
    public const USER_MIKE = 'mike@mike.com';
    public const USER_JACK = 'jack@jack.com';


    public function __construct (UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Create user Bob --- admin
        $bob_user = new User();

        $bob_user->setEmail(self::USER_BOB_ADMIN);
        $bob_user->setRoles(["ROLE_ADMIN"]);
        // encode password
        $encodePassword = $this->encoder->encodePassword($bob_user, 123);
        $bob_user->setPassword($encodePassword);
        $bob_user->setName('Bob');
        $bob_user->setPhone('123-123-13');
        $bob_user->setPhoto('ava_2.jpeg');
        $bob_user->setCreatedAt(new \DateTime());

        $manager->persist($bob_user);
        $manager->flush();
        $this->addReference(self::USER_BOB_ADMIN, $bob_user);
    

        // Create user Mike
        $mike_user = new User();

        $mike_user->setEmail(self::USER_MIKE);
        // encode password
        $encodePassword = $this->encoder->encodePassword($mike_user, 123);
        $mike_user->setPassword($encodePassword);
        $mike_user->setName('Mike');
        $mike_user->setPhone('345-345-345');
        $mike_user->setPhoto('ava_1.png');
        $mike_user->setCreatedAt(new \DateTime());


        $manager->persist($mike_user);
        $manager->flush();
        $this->addReference(self::USER_MIKE, $mike_user);


        // Create user Jack
        $jack_user = new User();

        $jack_user->setEmail(self::USER_JACK);
        // encode password
        $encodePassword = $this->encoder->encodePassword($jack_user, 123);
        $jack_user->setPassword($encodePassword);
        $jack_user->setName('Jake');
        $jack_user->setPhone('567-567-567');
        $jack_user->setPhoto('ava_3.png');
        $jack_user->setCreatedAt(new \DateTime());

        
        $manager->persist($jack_user);
        $manager->flush();
        $this->addReference(self::USER_JACK, $jack_user);

    }
}
