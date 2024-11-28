<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    public function userList() {
        return $this->hasOne(Admin::class, 'id', 'user_id')->select('id', 'name', 'avatar');
    }
}
