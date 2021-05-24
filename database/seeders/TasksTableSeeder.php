<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 3) as $num) { //rangeで1~3の範囲を$numに代入
            DB::table('tasks')->insert([
                'folder_id' => 1,
                'title' => "サンプルタスク {$num}", //サンプルタスク1 2 3 が作成されるよ～
                'status' => $num, // 1 2 3 が作成されるよん
                'due_date' => Carbon::now()->addDay($num), //CarbonライブラリのaddDayメソッドを使用。現在日時から$num分加算した日付を表示するよ～
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}