<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'item_name' => ['required'],
            'description' => ['required', 'max:255'],
            'brand_name' => ['required'],
            'item_img' => ['required', 'mimes:jpeg,png'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'condition' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
    public function messages()
    {
        return [
            'item_name.required' => '商品名は必須です',
            'description.required' => '商品の説明は必須です',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'item_img.required' => '商品の画像は必須です',
            'item_img.mimes' => '商品の画像はPNGまたはJPEG形式でアップロードしてください',
            'categories.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品の価格を入力してください',
            'price.numeric' => '商品の価格は数値で入力してください',
            'price.min' => '商品の価格は0円以上を入力してください',
        ];
    }
}
