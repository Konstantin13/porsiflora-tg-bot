<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'number' => ['required', 'string', 'regex:/\S/'],
            'total' => ['required', 'numeric', 'min:0'],
            'customerName' => ['required', 'string', 'regex:/\S/'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'number.regex' => 'The number field must not be empty.',
            'customerName.regex' => 'The customerName field must not be empty.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'shopId' => (int) $this->route('shopId'),
            'number' => is_string($this->number) ? trim($this->number) : $this->number,
            'customerName' => is_string($this->customerName) ? trim($this->customerName) : $this->customerName,
        ]);
    }
}
