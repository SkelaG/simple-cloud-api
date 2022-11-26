<?php

namespace App\Services;

use App\Dto\CreateUserDto;
use App\Events\UserCreatedEvent;
use App\Models\User;
use Hash;

class UsersService
{
    public function create(CreateUserDto $dto): User
    {
        $user = new User();
        $user->name = $dto->getName();
        $user->email = $dto->getEmail();
        $user->password = Hash::make($dto->getPassword());
        $user->save();

        event(new UserCreatedEvent($user->id));

        return $user;
    }
}
