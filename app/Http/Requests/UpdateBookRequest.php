<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => [
                'required',
                'string',
                'max:13',
                Rule::unique('books')->ignore($this->book)
            ],
            'publication_date' => 'required|date',
            'genre' => 'required|string|max:255',
            'number_of_copies' => 'required|integer',
        ];
    }
}
