<?php

namespace App\Http\Requests; // バリデーションを行うクラス

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() //リクエストの内容に基づいた権限チェック機能
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
            'title' => 'required|max:20', // keyはhtml側のinpot要素のname属性に対応。requiredは必須設定。
        ];
    }
    public function attributes() // ModelのGetHogeAttributeメソッドとは違うので注意。
    {
        return [
        'title' => 'フォルダ名', // attributes内のカラムtitleをフォルダ名という名称に変更する。
    ];
    }
}
