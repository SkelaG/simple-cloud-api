<?php

namespace App\Listeners;

use App\Dto\CreateFileInfoDto;
use App\Enums\FileInfoType;
use App\Events\UserCreatedEvent;
use App\Services\FileInfosService;

class CreateRootDirectoryListener
{
    public function __construct()
    {
    }

    public function handle(UserCreatedEvent $event)
    {
        return resolve(FileInfosService::class)->create(new CreateFileInfoDto(
            $event->getUserId(),
            null,
            FileInfoType::Directory,
            'root',
        ));
    }
}
