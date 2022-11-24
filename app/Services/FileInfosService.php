<?php

namespace App\Services;

use App\Dto\CreateFileInfoDto;
use App\Enums\FileInfoType;
use App\Models\FileInfo;
use Illuminate\Database\Eloquent\Collection;

class FileInfosService
{
    public function create(CreateFileInfoDto $dto): FileInfo
    {
        if ($parentId = $dto->getParentId()) {
            FileInfo::where('type', FileInfoType::Folder->value)->findOrFail($parentId);
        }

        $fileInfo = new FileInfo();
        $fileInfo->user_id = $dto->getUserId();
        $fileInfo->file_info_id = $parentId;
        $fileInfo->type = $dto->getType()->value;
        $fileInfo->path = $dto->getPath();
        $fileInfo->name = $dto->getName();
        $fileInfo->save();

        return $fileInfo;
    }

    public function getList(string $userId, ?string $folderId): Collection
    {
        if ($folderId) {
            $folder = FileInfo::where('user_id', $userId)->findOrFail($folderId);
            return $folder->children()->get();
        } else {
            return FileInfo::where('user_id', $userId)->whereNull('file_info_id')->get();
        }
    }

    public function rename(string $id, string $name): FileInfo
    {
        $fileInfo = FileInfo::findOrFail($id);
        $fileInfo->name = $name;
        $fileInfo->save();

        return $fileInfo;
    }
}
