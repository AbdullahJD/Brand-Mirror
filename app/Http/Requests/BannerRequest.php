<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'title' => 'nullable|string|max:255',

            'image' => $this->isMethod('post')
                ? 'required|image|max:2048'
                : 'nullable|image|max:2048',

            'link' => 'nullable|url',

            'status' => 'nullable|boolean',
        ];
    }
}
