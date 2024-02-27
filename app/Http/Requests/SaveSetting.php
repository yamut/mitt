<?php

namespace App\Http\Requests;

use App\Enums\HttpStatus;
use App\Rules\EnumRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveSetting extends FormRequest
{
    public function rules(): array
    {
        return [
            'endpoint' => ['string', 'required'],
            'code' => ['required', 'integer', new EnumRule(HttpStatus::class)],
            'body' => ['string', 'sometimes', 'nullable'],
        ];
    }
}
