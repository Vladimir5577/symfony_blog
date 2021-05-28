<?php

namespace App\UseCases\User\Edit;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public int $id;

    public ?string $photo;

    public ?string $name;

    public ?string $phone;

    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    public string $email;


    /**
     * @param array $options
     * @return $this
     * [
     *  'photo' => 'dasdasd',
     *  'phone' => '1928373',
     *  'email' => 'email@mail.com',
     * ]
     */
    public static function createFromArray(array $options) : self{
        $command = new self();
        foreach ($options as $optionName => $optionValue){
            $command->$optionName = $optionValue;
        }
        return $command;
    }


    public static function createFromUser(User $user): self {
        $command = new self();
        $command->id = $user->getId();
        $command->phone = $user->getPhone();
        $command->name = $user->getName();
        $command->email = $user->getEmail();
        $command->phone = $user->getPhoto();
        return $command;
    }
}