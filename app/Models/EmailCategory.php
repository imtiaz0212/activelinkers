<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailCategory extends Model
{
    use HasFactory, SoftDeletes;

    static function categoryList()
    {
        return EmailCategory::select('id', 'name')->get();
    }

}
