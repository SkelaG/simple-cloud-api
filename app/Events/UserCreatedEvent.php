<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class UserCreatedEvent
{
    use Dispatchable;

    public function __construct(private readonly int $userId)
    {
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
