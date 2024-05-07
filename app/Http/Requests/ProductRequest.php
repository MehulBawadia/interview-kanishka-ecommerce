<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $imageRequiredOrNull = $this->isMethod('POST') ? 'required' : 'nullable';

        return [
            'name' => ['required', 'string', 'max:255', 'unique:products,name,'.optional($this->product)->id],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'price' => ['required', 'numeric', 'min:0.0'],
            'image' => [$imageRequiredOrNull, 'image', 'mimes:jpeg,jpg,png', 'max:1024'],
        ];
    }
}
