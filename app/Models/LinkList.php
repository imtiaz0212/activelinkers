<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkList extends Model
{
    use HasFactory, SoftDeletes;

    public function linkPrice() {
        return $this->hasOne(LinkPrice::class, 'id');
    }
    public function publisher() {
        return $this->hasOne(Publisher::class, 'id', 'publisher_id');
    }
    
    public function countryList() {
        return $this->hasMany(LinkVisitedCountry::class, 'link_id');
    }

}
