<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    /**
     * 状態定義
     */
    const STATUS = [ //定数STATUSを宣言 //statusカラムに対応した key vaule を書いてる
        1 => [ 'label' => '未着手', 'class' => 'label-danger' ],
        2 => [ 'label' => '着手中', 'class' => 'label-info' ],
        3 => [ 'label' => '完了', 'class' => '' ],
    ];

    /**
     * 状態のラベル
     * @return string
     */
    public function getStatusLabelAttribute() //getHogeAttributeメソッドでアクセサを設定できる
    {
        // 状態値
        $status = $this->attributes['status']; // attributes内にモデルのデータが格納されている。ここでstatusカラムの値を取得して$statusに格納

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label']; // 定数STATUS内の属性データstatusの値に対応したlabelのvauleを取り出す
    }
    /**
      * 状態を表すHTMLクラス
      * @return string
      */
    public function getStatusClassAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];
      
        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }
      
        return self::STATUS[$status]['class'];
    }
    /**
     * 整形した期限日
     * @return string
     */
    public function getFormattedDueDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])
            ->format('Y/m/d');
    }
}
