<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ShowTelegramStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'shopId' => ['required', 'integer', 'exists:shops,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'shopId' => (int) $this->route('shopId'),
        ]);
    }
}
