<?php

namespace App\Http\Controllers;

use App\Models\ImageManager;
use Illuminate\Http\Request;

class ImageManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(['permission:mail image manager,admin'])->only('index');
        $this->middleware(['permission:mail image create,admin'])->only('store');
        $this->middleware(['permission:mail image edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:mail image destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'mailBox';
        $this->data['activeSubMenu'] = 'imageManager';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = ImageManager::all();

        return view('mailbox.images', $this->data);
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
        if (!empty($request->file('images'))) {
            foreach ($request->file('images') as $key => $value) {

                $file     = $value->getClientOriginalName();
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $fileType = pathinfo($file, PATHINFO_EXTENSION);

                $data = new ImageManager;

                $data->name = $fileName;
                $data->img_type = $fileType;
                $data->img_path = uploadFile($request->file('images')[$key], 'public/uploads/email-assets');

                $data->save();
            }
        }

        flash()->addSuccess('Image Upload successful.');
        return redirect()->route('admin.email.images');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ImageManager::find(($id));

        if (file_exists($data->img_path))
            unlink($data->img_path);

        $data->delete();

        flash()->addSuccess('Image Deleted successfully', 'Delete');

        return redirect()->route('admin.email.images');
    }
}
