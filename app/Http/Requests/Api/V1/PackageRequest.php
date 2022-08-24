<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PackageRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'data.*.tracking_code' => ['required',Rule::unique('packages','tracking_code')],
            'data.*.shipping_price'=> ['required'],
            'data.*.price'=> ['required'],
            'data.*.category'=> ['required'],
            'data.*.first_name.*'=> ['required',Rule::exists('users','first_name')],
            'data.*.last_name.*'=> ['required',Rule::exists('users','last_name')],
            'data.*.phone_number.*'=> ['required',Rule::exists('users','phone_number')],
            'data.*.email.*'=> ['required','email',Rule::exists('users','email')],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()->all()], 422);
        throw new ValidationException($validator, $response);
    }
}
