<?php

namespace App\Http\Controllers;

use App\Dto\CreateFileInfoDto;
use App\Enums\FileInfoType;
use App\Http\Requests\CreateFileRequest;
use App\Http\Requests\CreateDirectoryRequest;
use App\Http\Requests\GetFilesRequest;
use App\Http\Requests\RenameFileRequest;
use App\Http\Resources\FileInfoResource;
use App\Services\FileInfosService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FileInfosController extends Controller
{
    public function __construct(
        private readonly FileInfosService $service
    ) {
    }

    public function index(GetFilesRequest $request)
    {
        return new FileInfoResource($this->service->getDirectory(auth()->id(), $request->input('directory_id')));
    }

    public function uploadFile(CreateFileRequest $request)
    {
        $uploadedFile = $request->file('file');

        if (!($fileName = $request->input('name'))) {
            $fileName = $uploadedFile->getClientOriginalName();
        }

        $path = \Storage::putFile('files', $uploadedFile);
        try {
            return new FileInfoResource($this->service->create(new CreateFileInfoDto(
                auth()->id(),
                $request->input('parent_id'),
                FileInfoType::File,
                $fileName,
                $path,
                $uploadedFile->getClientOriginalExtension(),
            )));
        } catch (ModelNotFoundException $exception) {
            \Storage::delete($path);
            throw $exception;
        }
    }

    public function createDirectory(CreateDirectoryRequest $request)
    {
        return new FileInfoResource($this->service->create(new CreateFileInfoDto(
            auth()->id(),
            $request->input('parent_id'),
            FileInfoType::Directory,
            $request->input('name'),
        )));
    }

    public function download(string $id)
    {
        $fileInfo = $this->service->getFileInfoForDownload($id, auth()->id());
        return \Storage::download($fileInfo->path, $fileInfo->name);
    }

    public function rename(RenameFileRequest $request, string $id)
    {
        return new FileInfoResource($this->service->rename($id, $request->input('name'), auth()->id()));
    }

    public function destroy(string $id)
    {
        $this->service->delete($id, auth()->id());
    }
}
