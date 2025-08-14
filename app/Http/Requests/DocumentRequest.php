<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'document' => 'required|file|mimes:pdf',
        ];
    }
}