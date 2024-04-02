<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'cover_picture' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:2048',
            'description' => 'sometimes|string',
            'trailer' => 'sometimes|string',
            'category' => 'required|string',
            'subcategory' => 'required|string',
            'dates' => 'sometimes|array',
            'dates.*.day' => 'sometimes|integer',
            'dates.*.month' => 'sometimes|string',
            'dates.*.day_of_week' => 'sometimes|string',
            'dates.*.duration' => 'sometimes|integer',
            'dates.*.cinema' => 'sometimes|string',
            'dates.*.hall' => 'sometimes|string',
            'dates.*.price' => 'sometimes|integer',
            'dates.*.age_limit' => 'sometimes|integer|regex:/^\d{1,2}$/',
            'dates.*.time' => 'sometimes|string',
            'images' => 'sometimes|array',
            'images.*' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }
}
