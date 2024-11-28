<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailFrom extends Model
{
    use HasFactory;

    static function emailList()
    {
        return EmailFrom::select('id', 'name', 'email')->where('status', 1)->get();
    }
}
