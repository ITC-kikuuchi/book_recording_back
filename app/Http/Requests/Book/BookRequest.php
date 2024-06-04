<?php

namespace App\Http\Requests\Book;

use App\Models\Book;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookRequest extends FormRequest
{
    use ResponseTrait;

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
            Book::TITLE => ['required', 'max:255'],
            Book::AUTHOR => ['max:255'],
            Book::GENRE => ['max:255'],
            Book::PUBLISHER => ['max:255'],
            Book::ISBN => ['max:255'],
            Book::COVER_IMAGE => ['mimes:jpeg,jpg,png', 'max:2048'],
            Book::USER_ID => ['required', 'integer'],
        ];
    }

    /**
     * エラーハンドリング
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->unprocessableEntityResponse($validator->errors()->toArray()));
    }
}
