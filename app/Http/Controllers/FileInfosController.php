<?php

namespace App\Http\Controllers;

use App\Dto\CreateFileInfoDto;
use App\Enums\FileInfoType;
use App\Http\Requests\CreateFolderRequest;
use App\Http\Requests\GetFilesRequest;
use App\Http\Requests\RenameFileRequest;
use App\Models\FileInfo;
use App\Services\FileInfosService;
use Illuminate\Http\Request;

class FileInfosController extends Controller
{
    public function __construct(
        private readonly FileInfosService $service
    )
    {
    }

    public function index(GetFilesRequest $request)
    {
        return $this->service->getList(auth()->id(), $request->input('folder_id'));
    }

    public function uploadFile()
    {

    }

    public function createFolder(CreateFolderRequest $request)
    {
        return $this->service->create(new CreateFileInfoDto(
            auth()->id(),
            $request->input('parent_id'),
            FileInfoType::Folder,
            $request->input('name'),
        ));
    }

    public function show(FileInfo $fileInfo)
    {
    }

    public function rename(RenameFileRequest $request, string $id)
    {
        return $this->service->rename($id, $request->input('name'));
    }

    public function destroy(string $id)
    {
    }
}
