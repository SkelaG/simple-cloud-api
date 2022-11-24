<?php

namespace App\Services;

use App\Dto\CreateFileInfoDto;
use App\Models\FileInfo;

class FileInfosService
{
    public function create(CreateFileInfoDto $dto): FileInfo
    {
        $fileInfo = new FileInfo();
        $fileInfo->user_id = $dto->getUserId();
        $fileInfo->file_info_id = $dto->getParentId();
        $fileInfo->type = $dto->getType()->value;
        $fileInfo->path = $dto->getPath();
        $fileInfo->name = $dto->getName();
        $fileInfo->save();

        return $fileInfo;
    }
}
