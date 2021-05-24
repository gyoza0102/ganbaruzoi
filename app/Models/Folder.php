<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'folder_id', 'id'); //第二引数にTasksテーブルが持つ外部キー、第三引数はhasManyが定義されている側のテーブルが持つ、外部キーに紐づけられたid
    }
}
