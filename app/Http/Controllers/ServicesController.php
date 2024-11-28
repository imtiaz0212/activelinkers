<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:services,admin'])->only('index');
        $this->middleware(['permission:services create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:services edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:services destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'services';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Service::with('serviceCategory')->orderBy('created_at', 'desc')->get();

        return view('services.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $this->data['serviceCategoryList'] = ServiceCategory::categoryList();

        return view('services.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Service;

        $data->created = date('Y-m-d');
        $data->title = $request->title;
        $data->subtitle = $request->subtitle;
        $data->short_description = $request->short_description;
        $data->reach = $request->reach;
        $data->reach_percent = $request->reach_percent;
        $data->page_url = $request->page_url;
        $data->icon = $request->icon;
        $data->description = $request->description;
        $data->service_category_id = $request->service_category_id;
        $data->tag_title = $request->tag_title;
        $data->tags = json_encode($request->tags);

        if ($request->file('featured_image')) {
            $data->images = uploadFile($request->file('featured_image'), 'public/uploads/Services');
        }

        $data->save();

        flash()->addSuccess('Services add successful.');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['serviceCategoryList'] = ServiceCategory::categoryList();
        $this->data['info'] = Service::find($id);

        return view('services.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty ($request->id)) {

            $data = Service::find($request->id);

            $data->created             = date('Y-m-d');
            $data->title               = $request->title;
            $data->subtitle            = $request->subtitle;
            $data->short_description   = $request->short_description;
            $data->reach               = $request->reach;
            $data->reach_percent       = $request->reach_percent;
            $data->page_url            = $data->page_url;
            $data->icon                = $request->icon;
            $data->description         = $request->description;
            $data->service_category_id = $request->service_category_id;
            $data->tag_title           = $request->tag_title;
            $data->tags                = json_encode($request->tags);

            if (!empty ($request->file('featured_image'))) {
                if (file_exists($data->images))
                    unlink($data->images);
                $data->images = uploadImage($request->file('featured_image'), 'public/uploads/Services');
            } else {
                $data->images = $data->images;
            }

            $data->save();

            flash()->addSuccess('Services update successful.', 'Update');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Service::find($id);

        if (file_exists($data->images))
            unlink($data->images);

        $data->delete();

        flash()->addSuccess('Services delete successful.', 'Delete');

        return redirect()->route('admin.services');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFeaturedImage(string $id)
    {
        $data = Service::find($id);
        if (file_exists($data->images))
            unlink($data->images);

        $data->images = null;

        $data->save();

        flash()->addSuccess('Featured image delete successful.', 'Delete');

        return redirect()->back();
    }
}
