<?php

namespace App\UseCases\User\Edit;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    private UserRepository $users;
    private EntityManagerInterface $em;

    public function __construct(UserRepository $repository, EntityManagerInterface $em)
    {
        $this->users = $repository;
        $this->em = $em;
    }

    public function handle(Command $command) {
        $user = $this->users->find($command->id);

        if(!$user){
            throw new \DomainException('not found user with id id');
        }

        $user->setName($command->name);
        $user->setPhoto($command->photo);
        $user->setPhone($command->phone);
        $user->setEmail($command->email);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }
}