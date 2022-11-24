<?php

namespace App\Http\Requests;

use App\Dto\CreateUserDto;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
    }

    public function getDto(): CreateUserDto
    {
        return new CreateUserDto(
            $this->input('name'),
            $this->input('email'),
            $this->input('password'),
        );
    }
}
