<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDirectoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => 'required|string',
            'name' => 'required|string',
        ];
    }
}
