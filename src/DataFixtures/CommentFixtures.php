<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Bob to Mike
        $comment = new Comment();

        $comment->setUserId($this->getReference(UserFixtures::USER_BOB_ADMIN));
        $comment->setPostId($this->getReference(PostFixtures::MIKE_POST_1));

        $comment->setComment('Bob write a comment to Mike');

        $manager->persist($comment);
        $manager->flush();


        // Bob to Jack
        $comment = new Comment();

        $comment->setUserId($this->getReference(UserFixtures::USER_BOB_ADMIN));
        $comment->setPostId($this->getReference(PostFixtures::JACK_POST_1));

        $comment->setComment('Bob write a comment to Jack');

        $manager->persist($comment);
        $manager->flush();


        // Mike to Bob
        $comment = new Comment();

        $comment->setUserId($this->getReference(UserFixtures::USER_MIKE));
        $comment->setPostId($this->getReference(PostFixtures::BOB_POST_1));

        $comment->setComment('Mike write a comment to Bob');

        $manager->persist($comment);
        $manager->flush();

        // Mike to Jack
        $comment = new Comment();

        $comment->setUserId($this->getReference(UserFixtures::USER_MIKE));
        $comment->setPostId($this->getReference(PostFixtures::JACK_POST_1));

        $comment->setComment('Mike write a comment to Jack');

        $manager->persist($comment);
        $manager->flush();

        // Jack to Bob
        $comment = new Comment();

        $comment->setUserId($this->getReference(UserFixtures::USER_JACK));
        $comment->setPostId($this->getReference(PostFixtures::BOB_POST_2));

        $comment->setComment('Jack write a comment to Bob');

        $manager->persist($comment);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PostFixtures::class,
        ];
    }
}
