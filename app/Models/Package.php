<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    public function service() {
        return $this->hasOne(Service::class, 'id', 'service_id')->select('id', 'title');
    }


    static function packagesList($pid) {

        $results = DB::table('packages')
        ->Join('services', 'services.id', '=', 'packages.service_id')
        ->Join('service_categories', 'service_categories.id', '=', 'services.service_category_id')
        ->select('packages.id', 'packages.title',  'packages.monthly', 'packages.yearly', 'packages.type', 'packages.service_id', 'services.title', 'services.page_url', 'service_categories.name as service_category_name')
        ->where('packages.id', $pid)->whereNull('packages.deleted_at')->first();

        return $results;
    }

    static function realtimeSearch($request) {
        $where = [];
    
        if (!empty($request->service_id)) {
            $where[] = ['service_id', $request->service_id];
        }
    
        if (!empty($request->type)) {
            $where[] = ['type', $request->type];
        }
    
        $results = Package::with('service')->where($where)->paginate(10)->withQueryString();
    
        $data['serviceId'] = $request->service_id;
        $data['serviceType'] = $request->type;

        $data['results'] = $results;

        return (object)$data;
    }
}
