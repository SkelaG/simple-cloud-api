<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|string',
            'name' => 'required|string',
        ];
    }
}
