<?php

namespace App\Http\Controllers;

use App\Models\NewsLatter;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:newsletter,admin'])->only('index');
        $this->middleware(['permission:newsletter destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'newsletter';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = NewsLatter::orderBy('created_at', 'desc')->get();

        return view('newsletter.index', $this->data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = NewsLatter::find($id);

        $data->delete();

        flash()->addSuccess('Newsletter delete successfully', 'Delete');

        return redirect()->route('admin.newsletter');
    }
}
