<?php

namespace App\Http\Controllers;

use App\Models\Information;

use Illuminate\Http\Request;

class WhyUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:why choose us,admin'])->only('index');
        $this->middleware(['permission:why choose us create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:why choose us edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:why choose us destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'why-us';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Information::where('type', 'why-us')->orderBy('created_at', 'desc')->get();

        return view('why-us.index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Information;

        $data->icon        = $request->icon;
        $data->type        = $request->type;
        $data->title       = $request->title;
        $data->description = $request->description;

        $data->save();

        flash()->addSuccess('Why Choose Us add successful.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Information $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return Information::find($request->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty ($request->id)) {

            $data = Information::find($request->id);

            $data->icon        = $request->icon;
            $data->type        = $request->type;
            $data->title       = $request->title;
            $data->description = $request->description;

            $data->save();
            flash()->addSuccess('Why Choose Us update successful.', 'Update');
        }
        return redirect()->route('admin.why-us');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Information::find($id);

        $data->delete();

        flash()->addSuccess('Why Choose Us delete successful.', 'Delete');

        return redirect()->route('admin.why-us');
    }
}
