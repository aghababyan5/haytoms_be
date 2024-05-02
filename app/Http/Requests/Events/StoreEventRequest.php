<?php

namespace App\Http\Requests\Events;

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
            'title_en'                  => 'nullable|string',
            'title_ru'                  => 'nullable|string',
            'title_am'                  => 'nullable|string',
            'cover_picture'             => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'description_en'            => 'nullable|string',
            'description_ru'            => 'nullable|string',
            'description_am'            => 'nullable|string',
            'trailer_url'               => 'nullable|string',
            'trailer_file'              => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:20480',
            'category'                  => 'required|string',
            'subcategories'             => 'required|array',
            'subcategories.*'           => 'required|string',
            'event_dates'               => 'nullable|array',
            'event_dates.*.day'         => 'nullable|integer',
            'event_dates.*.month'       => 'nullable|string',
            'event_dates.*.day_of_week' => 'nullable|string',
            'event_dates.*.duration'    => 'nullable|integer',
            'event_dates.*.cinema'      => 'nullable|string',
            'event_dates.*.hall'        => 'nullable|string',
            'event_dates.*.price'       => 'nullable|integer',
            'event_dates.*.age_limit'   => 'nullable|integer|regex:/^\d{1,2}$/',
            'event_dates.*.time'        => 'nullable|string',
            'images'                    => 'nullable|array',
            'images.*'                  => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'is_visible'                => 'required|boolean',
        ];
    }
}
