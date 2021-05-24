<?php
// namespaceを宣言しておく。　名前空間名\関数名;
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // runメソッドを呼び出す
    // プライベート、仕事、旅行がtitlesに入る
    // created_at,updated_atはCarbonメソッドで自動で現在日時が入る
    // idは自動採番のため省略している
    // table foldersに対してinsertしている
    public function run()
    {
        $user = DB::table('users')->first(); //firstメソッドでuserテーブルから1レコード取得する

        $titles = ['プライベート', '仕事', '旅行'];

        foreach ($titles as $title) {
            DB::table('folders')->insert([
                'title' => $title,
                'user_id' => $user->id, // $userに格納されたuserテーブルのレコードからidを取得する
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
