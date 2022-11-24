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
            FileInfo::where('type', FileInfoType::Folder->value)->where('user_id', $dto->getUserId())
                ->findOrFail($parentId);
        }

        $fileInfo = new FileInfo();
        $fileInfo->user_id = $dto->getUserId();
        $fileInfo->file_info_id = $parentId;
        $fileInfo->type = $dto->getType()->value;
        $fileInfo->path = $dto->getPath();
        $fileInfo->name = $dto->getName();
        $fileInfo->file_type = $dto->getFileType();
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

    public function rename(string $id, string $name, string $userId): FileInfo
    {
        $fileInfo = FileInfo::where('user_id', $userId)->findOrFail($id);
        $fileInfo->name = $name;
        $fileInfo->save();

        return $fileInfo;
    }

    public function delete(string $id, string $userId): void
    {
        $fileInfo = FileInfo::where('user_id', $userId)->findOrFail($id);
        $this->choseDeleteMethod($fileInfo);
    }

    private function deleteFolder(FileInfo $folder): void
    {
        foreach ($folder->children()->get() as $fileInfo) {
            $this->choseDeleteMethod($fileInfo);
        }

        $folder->delete();
    }

    private function deleteFile(FileInfo $file): void
    {
        \Storage::delete($file->path);
        $file->delete();
    }

    /**
     * @param  FileInfo  $fileInfo
     * @return void
     */
    private function choseDeleteMethod(FileInfo $fileInfo): void
    {
        switch (FileInfoType::tryFrom($fileInfo->type)) {
            case FileInfoType::Folder:
                $this->deleteFolder($fileInfo);
                break;
            case FileInfoType::File:
                $this->deleteFile($fileInfo);
                break;
        }
    }
}
