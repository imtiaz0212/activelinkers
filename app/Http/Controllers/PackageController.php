<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:package,admin'])->only('index');
        $this->middleware(['permission:package create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:package edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:package destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'package';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data['servicelist'] = Service::get();

        $this->data['info'] = Package::realtimeSearch($request);

        return view('package.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $this->data['servicelist'] = Service::get();

        return view('package.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Package;

        $data->created = date('Y-m-d');
        $data->service_id = $request->service_id;
        $data->type = $request->type;
        $data->title = $request->title;
        $data->short_description = $request->short_description;
        $data->features = json_encode($request->features);

        if ($request->monthly > 0) {
            $data->monthly = $request->monthly;
        }

        if ($request->yearly > 0) {
            $data->yearly = $request->yearly;
        }

        if (!empty ($request->is_recommended)) {
            $data->is_recommended = $request->is_recommended;
        } else {
            $data->is_recommended = 0;
        }

        $data->save();

        flash()->addSuccess('Package add successful.');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['servicelist'] = Service::get();
        $this->data['info'] = Package::find($id);

        return view('package.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty ($request->id)) {

            $data = Package::find($request->id);

            $data->created = date('Y-m-d');
            $data->service_id = $request->service_id;
            $data->type = $request->type;
            $data->title = $request->title;
            $data->short_description = $request->short_description;
            $data->features = json_encode($request->features);

            if ($request->monthly > 0) {
                $data->monthly = $request->monthly;
            }

            if ($request->yearly > 0) {
                $data->yearly = $request->yearly;
            }

            if (!empty ($request->is_recommended)) {
                $data->is_recommended = $request->is_recommended;
            } else {
                $data->is_recommended = 0;
            }

            $data->save();

            flash()->addSuccess('Package update successful.', 'Update');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Package::find($id);
        $data->delete();
        flash()->addSuccess('Package delete successful.', 'Delete');
        return redirect()->route('admin.package');
    }

}
