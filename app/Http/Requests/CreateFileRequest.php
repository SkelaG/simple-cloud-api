<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|file',
            'parent_id' => 'required|string',
            'name' => 'nullable|string',
        ];
    }
}
