<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditTask extends CreateTask //入力内容は途中まで同じなのでCreateTaskを継承させてやる
{
    public function rules()
    {
        $rule = parent::rules(); //親クラス(CreateTask)のRole要素を代入

        $status_rule = Rule::in(array_keys(Task::STATUS)); //Ruleメソッドのinメソッドは続く要素を配列で取得できる

        return $rule + [
            'status' => 'required|' . $status_rule, //親クラス(CreateTask)のRoleのバリデートにstatusを足す
        ];
    }

    public function attributes()
    {
        $attributes = parent::attributes();//親クラス(CreateTask)のattributes要素を代入

        return $attributes + [
            'status' => '状態', //CreateTaskのattributes(title=>タイトル,due_date=>期限日)にstatus=>状態 を足す
        ];
    }

    public function messages()
    {
        $messages = parent::messages();

        $status_labels = array_map(function ($item) {
            return $item['label'];
        }, Task::STATUS); //array_mapは続く要素を配列で取得するメソッド。 Task::STATUSからlabelを取得して配列に格納

        $status_labels = implode('、', $status_labels); //implodeは配列要素を文字列で連結する。この場合$status_labels内の文字を「、」で連結する。

        return $messages + [
            'status.in' => ':attribute には ' . $status_labels. ' のいずれかを指定してくださいな.',
        ];
    }
}
