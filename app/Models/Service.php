<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    public function packages() {
        return $this->hasMany(Package::class);
    }

    public function packagesList() {
        return $this->hasMany(Package::class, 'service_id');
    }

    public function serviceCategory() {
        return $this->hasOne(ServiceCategory::class, 'id', 'service_category_id')->select('id', 'name');
    }

}
