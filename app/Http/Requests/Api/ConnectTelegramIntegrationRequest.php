<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ConnectTelegramIntegrationRequest extends FormRequest
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
            'botToken' => ['required', 'string', 'regex:/\S/'],
            'chatId' => ['required', 'string', 'regex:/\S/'],
            'enabled' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'botToken.regex' => 'The botToken field must not be empty.',
            'chatId.regex' => 'The chatId field must not be empty.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'shopId' => (int) $this->route('shopId'),
            'botToken' => is_string($this->botToken) ? trim($this->botToken) : $this->botToken,
            'chatId' => is_string($this->chatId) ? trim($this->chatId) : $this->chatId,
        ]);
    }
}
