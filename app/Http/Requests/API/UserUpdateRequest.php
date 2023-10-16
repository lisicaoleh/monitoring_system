<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email:rfc,dns',
            'password' => 'min:4|max:24',
            'mobile' => 'string',
            'role' => 'string|in:'. implode(',', config('app.user_roles')),
            'position_id' => 'nullable|int',
            'facility_id' => 'int',
        ];
    }
}
