<?php

namespace App\Http\Requests;

use App\Enums\HttpStatus;
use App\Rules\EnumRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveSetting extends FormRequest
{
    /**
     * @return mixed[][]
     */
    public function rules(): array
    {
        return [
            'slug' => ['string', 'required', 'unique:App\Models\Response,'],
            'http_status' => ['required', 'integer', new EnumRule(HttpStatus::class)],
            'body' => ['string', 'sometimes', 'nullable'],
            'headers' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
