<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            "name" => "required",
            "email" => "required",
            "password" => "required",
            "is_admin" => "required"
        ];
    }
}



