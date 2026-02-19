<?php

namespace App\Http\Requests\Api;

use App\Models\TelegramIntegration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'botToken' => ['nullable', 'string'],
            'chatId' => ['nullable', 'string'],
            'enabled' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'botToken.required' => 'The botToken field is required when creating a new integration.',
            'chatId.required' => 'The chatId field is required when creating a new integration.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $shopId = $this->integer('shopId');
            $hasExistingIntegration = TelegramIntegration::query()
                ->where('shop_id', $shopId)
                ->exists();

            if ($hasExistingIntegration) {
                return;
            }

            if ($this->isBlank($this->input('botToken'))) {
                $validator->errors()->add('botToken', 'The botToken field is required when creating a new integration.');
            }

            if ($this->isBlank($this->input('chatId'))) {
                $validator->errors()->add('chatId', 'The chatId field is required when creating a new integration.');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'shopId' => (int) $this->route('shopId'),
            'botToken' => is_string($this->botToken) ? trim($this->botToken) : $this->botToken,
            'chatId' => is_string($this->chatId) ? trim($this->chatId) : $this->chatId,
        ]);
    }

    private function isBlank(mixed $value): bool
    {
        return ! is_string($value) || trim($value) === '';
    }
}
