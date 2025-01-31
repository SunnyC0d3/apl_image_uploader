<?php

namespace App\Http\Requests\StorageSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStorageSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mode' => 'required|in:local,azure',
        ];
    }

    public function messages(): array
    {
        return [
            'mode.required' => 'Storage mode is required.',
            'mode.in' => 'Invalid storage mode. Allowed values: local or azure.',
        ];
    }
}
