<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['email'];

    public function category(){
        return $this->belongsTo(EmailCategory::class, 'email_category_id')->select('id', 'name');
    }
}
