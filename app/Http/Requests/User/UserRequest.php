<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

abstract class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        if ($this->has('password')) {
            $this->merge(
                ['password' => Hash::make($this->input('password'))]
            );
        }
    }

    public function validated(): array
    {
        if ($this->has('password')) {
            return array_merge(parent::validated(), ['password' => $this->input('password')]);
        }
        return parent::validated();
    }
}
