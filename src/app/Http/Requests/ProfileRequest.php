<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:20'],
            'address' => ['required'],
            'zipcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'icon_img' => ['nullable', 'mimes:jpeg,png'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '名前は必須です',
            'address.required' => '住所は必須です',
            'zipcode.required' => '郵便番号は必須です',
            'zipcode.regex' => '郵便番号は「123-4567」の形式で入力してください',
            'icon_img.mimes' => '画像はPNGまたはJPEG形式でアップロードしてください',
        ];
    }
}
