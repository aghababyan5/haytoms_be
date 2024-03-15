<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
            'title'         => 'required|string',
            'cover_picture' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
            'description'   => 'required|string',
            'trailer'       => 'required|string',
            'day'           => 'required|integer',
            'month'         => 'required|string',
            'day_of_week'   => 'required|string',
            'duration'      => 'required|integer',
            'cinema'        => 'required|string',
            'hall'          => 'required|string',
            'price'         => 'required|integer',
            'age_limit'     => 'sometimes|integer|regex:/^\d{2}$/',
            'time'          => 'required|string|regex:^(?:[01]\d|2[0-3]):[0-5]\d$',
        ];
    }
}
