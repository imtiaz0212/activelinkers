<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageContent extends Model
{
    use HasFactory, SoftDeletes;

    static function contentList($request)
    {

        $where = [];

        if (!empty($request->ccid)) {
            $where[] = ['content_category_id', $request->ccid];
        }

        return PageContent::with('contentCategory')->where($where)->orderBy('created', 'desc')->paginate(10)->withQueryString();
    }
}
