<?php

namespace App\Http\Controllers;

use App\Dto\CreateFileInfoDto;
use App\Enums\FileInfoType;
use App\Http\Requests\CreateFolderRequest;
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

    public function index()
    {

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

    public function update(Request $request, FileInfo $fileInfo)
    {
    }

    public function destroy(FileInfo $fileInfo)
    {
    }
}
