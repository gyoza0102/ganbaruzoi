<?php

namespace App\Http\Controllers;

use App\Models\Folder; // Folderクラスを操作するのでuse追加
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder; //バリデーションを行うためuse追加
use Illuminate\Support\Facades\Auth; // Authクラスをインポート

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(CreateFolder $request) // CreateFolderクラスを指定。中で継承しているFormRequestは、元々指定していたrequestクラスと互換性あり。リクエストヘッダや送信元IP,フォームの入力値等が含まれる
    {
        // folderモデルにレコードを挿入 idは自動採番される
        $folder = new Folder();
        // folderモデルのtitleカラムにrequest値を挿入
        $folder->title = $request->title;
        // ユーザーに紐づけて保存
        Auth::user()->folders()->save($folder); //Auth::userでユーザデータを取得してリレーションでフォルダモデルを保存
        // データベースに書き込む
        $folder->save();

        return redirect()->route('tasks.index', [ //フォルダを作成するルートは独自のviewを持つ必要ないので、作成後の画面としてtasks.indexの画面にリダイレクトしてあげる
        'folder' => $folder->id,
    ]);
    }
}
