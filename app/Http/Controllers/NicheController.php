<?php

namespace App\Http\Controllers;

use App\Models\Niche;
use Illuminate\Http\Request;

class NicheController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:niche,admin'])->only('index');
        $this->middleware(['permission:niche create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:niche edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:niche destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'niche';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Niche::orderBy('created_at', 'desc')->get();

        return view('niche.index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Niche;

        $data->created = date('Y-m-d');
        $data->name    = $request->name;

        $data->save();

        flash()->addSuccess('Niche add successful.');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return Niche::find($request->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty($request->id)) {

            $data = Niche::find($request->id);

            $data->name = $request->name;

            $data->save();
            flash()->addSuccess('Niche update successful.', 'Update');
        }
        return redirect()->route('admin.niche');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Niche::find($id);

        $data->delete();

        flash()->addSuccess('Niche delete successful.', 'Delete');
        return redirect()->route('admin.niche');
    }
}
