<?php

namespace App\Http\Requests\User;

class UserUpdateRequest extends UserRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string',
            'email'=>'required|string|email',
            'password'=>'min:8'
        ];
    }
}
