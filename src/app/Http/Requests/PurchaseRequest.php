<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' => ['required', 'in:card,konbini'],
            'zipcode' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
        ];
    }
    public function withValidator($validator) {
        $validator->after(function ($validator) {

            $user = $this->user();

            $inputZip = $this->input('zipcode');
            $inputAddress = $this->input('address');

            // ユーザー情報
            $userZip = $user?->zipcode;
            $userAddress = $user?->address;

            // ▼ 条件：どちらにも住所が無い場合エラー
            $hasInputAddress = $inputZip && $inputAddress;
            $hasUserAddress = $userZip && $userAddress;

            if (!$hasInputAddress && !$hasUserAddress) {
                $validator->errors()->add(
                    'address',
                    '配送先情報を入力するか、プロフィールに住所を登録してください'
                );
            }
        });
    }

    public function messages() {
        return [
            'payment_method.required' => '支払い方法を選択してください',
        ];
    }
}
