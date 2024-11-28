<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', // Add 'id' to the fillable array
        'order_id',
        'url',
        'entity_name',
        'live_url',
        'url_price',
        'anchor',
        'is_other_price',
        'link_insert',
        'other_price',
        'total',
    ];
}
