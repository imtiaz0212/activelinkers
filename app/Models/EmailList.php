<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\DataTables\Facades\DataTables;

class EmailList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['email'];

    public function category(){
        return $this->belongsTo(EmailCategory::class, 'email_category_id')->select('id', 'name');
    }

    static function searchEmailList($request)
    {
        $query = EmailList::with('category');

        if ($request->has('e_c_id') && $request->e_c_id !== 'all') {
            $query->where('email_category_id', $request->e_c_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '">';
            })
            ->addColumn('status_badge', function ($row) {
                return '<span class="badge ' . ($row->status == 1 ? ' badge-success' : 'badge-danger') . '">' . ($row->status == 1 ? 'Active' : 'Inactive') . ' </span>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="flex items-center gap-2.5 justify-end">
                                <a href="javascript:void(0)" data-modal-target="edit-modal" onclick="getData(' . $row->id . ');"
                                        data-modal-toggle="edit-modal" class="edit-action-btn"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="' . route('admin.email.destroy', $row->id) . '" onclick="return confirm(\'Do you want to delete this data?\')"
                                        class="delete-action-btn"><i class="fa-regular fa-trash-can"></i></a>
                            </div>';
            })
            ->rawColumns(['checkbox', 'status_badge', 'action'])
            ->make(true);
    }
}
