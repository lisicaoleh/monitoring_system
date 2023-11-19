<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required',
            'password' => 'required|min:4|max:24',
            'mobile' => 'required|string',
            'role' => 'required|string|in:'.config('app.user_roles.user').','.config('app.user_roles.manager'),
            'is_receive_push_notif' => 'boolean',
            'is_receive_sms_notif' => 'boolean',
            'is_receive_email_notif' => 'boolean',
            'position_id' => 'nullable|int',
            'facility_id' => 'required|int',
        ];
    }
}
