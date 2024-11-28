<?php

namespace App\Http\Controllers;

use App\Models\Brand;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:brand,admin'])->only('index');
        $this->middleware(['permission:brand create,admin'])->only(['store']);
        $this->middleware(['permission:brand edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:brand destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'brand';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Brand::orderBy('created_at', 'desc')->get();

        return view('brand.index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Brand;

        $data->created = date('Y-m-d');
        $data->url = $request->url;
        $data->title = $request->title;

        if ($request->file('images')) {
            $data->images = uploadFile($request->file('images'), 'public/uploads/brand');
        }

        $data->save();

        flash()->addSuccess('Brand add successful.');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return Brand::find($request->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty ($request->id)) {

            $data = Brand::find($request->id);

            $data->url = $request->url;
            $data->title = $request->title;

            $imagePath = $request->file('images');

            if (!empty ($imagePath)) {
                if (file_exists($data->images))
                    unlink($data->images);
                $data->images = uploadImage($imagePath, 'public/uploads/brand');
            }

            $data->save();
            flash()->addSuccess('Brand update successful.', 'Update');
        }
        return redirect()->route('admin.brand');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Brand::find($id);

        if (file_exists($data->images))
            unlink($data->images);

        $data->delete();

        flash()->addSuccess('Brand delete successful.', 'Delete');

        return redirect()->route('admin.brand');
    }
}
