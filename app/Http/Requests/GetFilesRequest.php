<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetFilesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'directory_id' => 'required|string',
        ];
    }
}
