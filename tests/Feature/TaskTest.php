<?php

namespace Tests\Feature;

use App\Http\Requests\CreateTask;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    // テストケースごとにデータベースをリフレッシュしてマイグレーションを再実行する
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        // テストケース実行前にフォルダデータを作成する
        $this->seed('FoldersTableSeeder');
    }

    /**
     * タイトルがmaxより多い場合にバリデーションエラー
     * @test
     */
    public function title_should_be_max()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'あああああああああああああああああああああ', // $responseに不正なデータを格納
            'due_date' => Carbon::today()->format('Y/m/d'),
        ]);

        $response->assertSessionHasErrors([ //エラーメッセージがあることを確認するメソッド
            'title' => 'タイトル は 20 文字以内で入力してくださいな.',
        ]);
    }

    /**
     * 期限日が過去日付の場合はバリデーションエラー
     * @test
     */
    public function due_date_should_be_date()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => 123, // $responseに不正なデータを格納
        ]);

        $response->assertSessionHasErrors([ //エラーメッセージがあることを確認するメソッド
            'due_date' => '期限日 には日付を入力してくださいな.',
        ]);
    }
    /**
     * 期限日が過去日付の場合はバリデーションエラー
     * @test
     */
    public function due_date_should_not_be_past()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'), // 不正なデータ（昨日の日付）
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してくださいな.',
        ]);
    }
    /**
  * 状態が定義された値ではない場合はバリデーションエラー
  * @test
  */
    public function status_should_be_within_defined_numbers()
    {
        $this->seed('TasksTableSeeder');

        $response = $this->post('/folders/1/tasks/1/edit', [
        'title' => 'Sample task',
        'due_date' => Carbon::today()->format('Y/m/d'),
        'status' => 999, //1,2,3以外の場合はエラー
    ]);

        $response->assertSessionHasErrors([
        'status' => '状態 には 未着手、着手中、完了 のいずれかを指定してくださいな.',
    ]);
    }
}
