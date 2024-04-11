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
            'title_en'                  => 'sometimes|string',
            'title_ru'                  => 'sometimes|string',
            'title_am'                  => 'sometimes|string',
            'cover_picture'             => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:2048',
            'description_en'            => 'sometimes|string',
            'description_ru'            => 'sometimes|string',
            'description_am'            => 'sometimes|string',
            'trailer'                   => 'sometimes|string',
            'category'                  => 'required|string',
            'subcategories'             => 'required|array',
            'subcategories.*'           => 'required|string',
            'event_dates'               => 'sometimes|array',
            'event_dates.*.day'         => 'sometimes|integer',
            'event_dates.*.month'       => 'sometimes|string',
            'event_dates.*.day_of_week' => 'sometimes|string',
            'event_dates.*.duration'    => 'sometimes|integer',
            'event_dates.*.cinema'      => 'sometimes|string',
            'event_dates.*.hall'        => 'sometimes|string',
            'event_dates.*.price'       => 'sometimes|integer',
            'event_dates.*.age_limit'   => 'sometimes|integer|regex:/^\d{1,2}$/',
            'event_dates.*.time'        => 'sometimes|string',
            'images'                    => 'sometimes|array',
            'images.*'                  => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }
}
