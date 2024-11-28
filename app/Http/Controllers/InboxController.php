<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;

use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:inbox,admin'])->only('index');
        $this->middleware(['permission:inbox show,admin'])->only('show');
        $this->middleware(['permission:inbox destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'inbox';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = ContactUs::orderBy('created_at', 'desc')->get();

        return view('inbox.index', $this->data);
    }

    /**
     * Show a single inbox message
     */
    public function show(string $id)
    {
        $message = ContactUs::find($id);

        if (!$message) {
            flash()->addSuccess('Not Found', 'Delete');
        }

        $message->seen = 1;
        $message->save();

        $this->data['info'] = $message;

        return view('inbox.show', $this->data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ContactUs::find($id);

        $data->delete();

        flash()->addSuccess('Contact message delete successfully', 'Delete');

        return redirect()->route('admin.inbox');
    }
}
