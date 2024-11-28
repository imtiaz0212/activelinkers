<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use HasFactory, SoftDeletes;

    static function templateList($whereIn = [], $whereNotIn = [])
    {
        if (!empty($whereIn) && is_array($whereIn)){
            return EmailTemplate::select('id', 'name', 'subject')->where('status', 1)->whereIn('id', $whereIn)->get();
        }

        if (!empty($whereNotIn) && is_array($whereNotIn)){
            return EmailTemplate::select('id', 'name', 'subject')->where('status', 1)->whereNotIn('id', $whereNotIn)->get();
        }
    }
}
