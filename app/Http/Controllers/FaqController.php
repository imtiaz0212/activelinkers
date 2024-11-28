<?php

namespace App\Http\Controllers;

use App\Models\Information;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:faq,admin'])->only('index');
        $this->middleware(['permission:faq create,admin'])->only(['store']);
        $this->middleware(['permission:faq edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:faq destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'faq';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Information::where('type', 'faq')->orderBy('created_at', 'desc')->get();

        return view('faq.index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Information;

        $data->type = $request->type;
        $data->title = $request->title;
        $data->description = $request->description;

        $data->save();

        flash()->addSuccess('FAQ add successful.');

        return redirect()->back();
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

            $data->type = $request->type;
            $data->title = $request->title;
            $data->description = $request->description;

            $data->save();
            flash()->addSuccess('FAQ update successful.', 'Update');
        }
        return redirect()->route('admin.faq');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Information::find($id);

        $data->delete();

        flash()->addSuccess('FAQ delete successful.', 'Delete');

        return redirect()->route('admin.faq');
    }
}
