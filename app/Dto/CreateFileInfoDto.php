<?php

namespace App\Dto;

use App\Enums\FileInfoType;

class CreateFileInfoDto extends Dto
{
    public function __construct(
        private readonly string $userId,
        private readonly ?string $parentId,
        private readonly FileInfoType $type,
        private readonly string $name,
        private readonly ?string $path = null,
        private readonly ?string $fileType = null,
    )
    {
    }

    /**
     * @return string|null
     */
    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * @return FileInfoType
     */
    public function getType(): FileInfoType
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
