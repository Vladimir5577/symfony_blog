<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Post;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{

    public const BOB_POST_1 = 'Javascript';
    public const BOB_POST_2 = 'Laravel';
    public const BOB_POST_3 = 'React js';

    public const MIKE_POST_1 = 'Symfony';
    public const MIKE_POST_2 = 'Docker';
    public const MIKE_POST_3 = 'MySQL';

    public const JACK_POST_1 = 'Linux';
    public const JACK_POST_2 = 'Laravel Framework';
    public const JACK_POST_3 = 'PHP Symfony';


    public function load(ObjectManager $manager)
    {

        // 1 Bob post
        $bob_post = new Post();

        $bob_post->setUserId($this->getReference(UserFixtures::USER_BOB_ADMIN));

        $bob_post->setTitle(self::BOB_POST_1);
        $bob_post->setDescription('JavaScript is a text-based programming language used both on the client-side and server-side that allows you to make web pages interactive. Where HTML and CSS are languages that give structure and style to web pages, JavaScript gives web pages interactive elements that engage a user. Common examples of JavaScript that you might use every day include the search box on Amazon, a news recap video embedded on The New York Times, or refreshing your Twitter feed.  ');
        $bob_post->setImage('prog_1.png');
        $bob_post->setCreatedAt(new \DateTime());

        $manager->persist($bob_post);
        $manager->flush();
        $this->addReference(self::BOB_POST_1, $bob_post);


        // 2 Bob post
        $bob_post = new Post();

        $bob_post->setUserId($this->getReference(UserFixtures::USER_BOB_ADMIN));

        $bob_post->setTitle(self::BOB_POST_2);
        $bob_post->setDescription('Laravel is a web application framework with expressive, elegant syntax. A web framework provides a structure and starting point for creating your application, allowing you to focus on creating something amazing while we sweat the details.

            Laravel strives to provide an amazing developer experience while providing powerful features such as thorough dependency injection, an expressive database abstraction layer, queues and scheduled jobs, unit and integration testing, and more.');
        $bob_post->setImage('prog_2.png');
        $bob_post->setCreatedAt(new \DateTime());

        $manager->persist($bob_post);
        $manager->flush();
        $this->addReference(self::BOB_POST_2, $bob_post);


        // 3 Bob post
        $bob_post = new Post();

        $bob_post->setUserId($this->getReference(UserFixtures::USER_BOB_ADMIN));

        $bob_post->setTitle(self::BOB_POST_3);
        $bob_post->setDescription('It provides a very simple start, there is no need to write a lot of boilerplate code, you just import it and start extendinng the primitive components and create the ones you need.');
        $bob_post->setImage('prog_3.png');
        $bob_post->setCreatedAt(new \DateTime());

        $manager->persist($bob_post);
        $manager->flush();
        $this->addReference(self::BOB_POST_3, $bob_post);


        // 1 Mike post
        $mike_post = new Post();

        $mike_post->setUserId($this->getReference(UserFixtures::USER_MIKE));

        $mike_post->setTitle(self::MIKE_POST_1);
        $mike_post->setDescription('Symfony Components
            Symfony Components are a set of decoupled and reusable PHP libraries. Battle-tested in thousands of projects and downloaded billions of times, they\'ve become the standard foundation on which the best PHP applications are built on. You can use any of these components in your own applications independently from the Symfony Framework.');
        $mike_post->setImage('prog_4.png');
        $mike_post->setCreatedAt(new \DateTime());

        $manager->persist($mike_post);
        $manager->flush();
        $this->addReference(self::MIKE_POST_1, $mike_post);


        // 2 Mike post
        $mike_post = new Post();

        $mike_post->setUserId($this->getReference(UserFixtures::USER_MIKE));

        $mike_post->setTitle(self::MIKE_POST_2);
        $mike_post->setDescription('Docker makes development efficient and predictable
            Docker takes away repetitive, mundane configuration tasks and is used throughout the development lifecycle for fast, easy and portable application development - desktop and cloud. Docker’s comprehensive end to end platform includes UIs, CLIs, APIs and security that are engineered to work together across the entire application delivery lifecycle.');
        $mike_post->setImage('prog_5.jpeg');
        $mike_post->setCreatedAt(new \DateTime());

        $manager->persist($mike_post);
        $manager->flush();
        $this->addReference(self::MIKE_POST_2, $mike_post);


        // 3 Mike post
        $mike_post = new Post();

        $mike_post->setUserId($this->getReference(UserFixtures::USER_MIKE));

        $mike_post->setTitle(self::MIKE_POST_3);
        $mike_post->setDescription('Over 2000 ISVs, OEMs, and VARs rely on MySQL as their products embedded database to make their applications, hardware and appliances more competitive, bring them to market faster, and lower their cost of goods sold.');
        $mike_post->setImage('prog_6.png');
        $mike_post->setCreatedAt(new \DateTime());

        $manager->persist($mike_post);
        $manager->flush();
        $this->addReference(self::MIKE_POST_3, $mike_post);


        // 1 Jack post
        $jack_post = new Post();

        $jack_post->setUserId($this->getReference(UserFixtures::USER_JACK));

        $jack_post->setTitle(self::JACK_POST_1);
        $jack_post->setDescription('There are many Linux distributions. I can’t even think of coming up with an exact number because you would find loads of Linux distros that differ from one another in one way or the other.
        Some of them just turn out to be a clone of one another while some of them tend to be unique. So, it’s kind of a mess – but that is the beauty of Linux.

        ');
        $jack_post->setImage('prog_7.png');
        $jack_post->setCreatedAt(new \DateTime());

        $manager->persist($jack_post);
        $manager->flush();
        $this->addReference(self::JACK_POST_1, $jack_post);


        // 2 Jack post
        $jack_post = new Post();

        $jack_post->setUserId($this->getReference(UserFixtures::USER_JACK));

        $jack_post->setTitle(self::JACK_POST_2);
        $jack_post->setDescription('Laravel is a web application framework with expressive, elegant syntax. A web framework provides a structure and starting point for creating your application, allowing you to focus on creating something amazing while we sweat the details.

            Laravel strives to provide an amazing developer experience while providing powerful features such as thorough dependency injection, an expressive database abstraction layer, queues and scheduled jobs, unit and integration testing, and more.');
        $jack_post->setImage('prog_8.png');
        $jack_post->setCreatedAt(new \DateTime());

        $manager->persist($jack_post);
        $manager->flush();
        $this->addReference(self::JACK_POST_2, $jack_post);


        // 3 Jack post
        $jack_post = new Post();

        $jack_post->setUserId($this->getReference(UserFixtures::USER_JACK));

        $jack_post->setTitle(self::JACK_POST_3);
        $jack_post->setDescription('Symfony Components
            Symfony Components are a set of decoupled and reusable PHP libraries. 
            Battle-tested in thousands of projects and downloaded billions of times, 
            they\'ve become the standard foundation on which the best PHP applications are built on. 
            You can use any of these components in your own applications independently from the Symfony Framework.');
        $jack_post->setImage('prog_9.png');
        $jack_post->setCreatedAt(new \DateTime());

        $manager->persist($jack_post);
        $manager->flush();
        $this->addReference(self::JACK_POST_3, $jack_post);

    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
