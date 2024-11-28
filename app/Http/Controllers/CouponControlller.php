<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponControlller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:coupons,admin'])->only('index');
        $this->middleware(['permission:coupon create,admin'])->only(['store']);
        $this->middleware(['permission:coupon edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:coupon delete,admin'])->only('destroy');

        $this->data['activeMenu'] = 'coupon';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Coupon::orderBy('created_at', 'desc')->get();

        return view('coupon.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Coupon;

        $data->code = $request->code;
        $data->type = $request->type;
        $data->discount = $request->discount;

        $data->save();

        flash()->addSuccess("Coupon added successfully!");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return Coupon::find($request->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty($request->id)) {
            $data = Coupon::find($request->id);

            $data->code = $request->code;
            $data->type = $request->type;
            $data->discount = $request->discount;
            $data->status = $request->status;

            $data->save();

            flash()->addSuccess("Coupon updated successfully!", 'Update');
        }

        return redirect()->route('admin.coupon');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Coupon::find($id);

        $data->delete();

        flash()->addSuccess("Coupon deleted successfully.", "Delete");
        return redirect()->route('admin.coupon');
    }
}
