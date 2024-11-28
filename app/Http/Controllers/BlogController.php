<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:blog,admin'])->only('index');
        $this->middleware(['permission:blog create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:blog edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:blog destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'blogs';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['info'] = Blog::with('userList')->orderBy('created_at', 'desc')->get();
        $this->data['userInfo'] = Admin::get();

        return view('blogs.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('blogs.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Blog;

        $user_id = Auth::user()->id;

        $readTime = readingTime($request->title, $request->subtitle, $request->short_description, $request->description);

        $data->created          = date('Y-m-d');
        $data->user_id          = $user_id;
        $data->title            = $request->title;
        $data->page_url         = $request->page_url;
        $data->subtitle         = $request->subtitle;
        $data->short_description= $request->short_description;
        $data->description      = $request->description;
        $data->read_time        = $readTime;

        $data->meta_title       = $request->meta_title;
        $data->meta_tag         = $request->meta_tag;
        $data->meta_description = $request->meta_description;

        if ($request->file('meta_image')) {
            $data->meta_image = uploadFile($request->file('meta_image'), 'public/uploads');
        }

        if ($request->file('featured_image')) {
            $data->featured_image = uploadFile($request->file('featured_image'), 'public/uploads/Services');
        }

        $data->save();

        flash()->addSuccess('Blog add successful.');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['info'] = Blog::find($id);

        return view('blogs.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!empty ($request->id)) {

            $data = Blog::find($request->id);
            $readTime = readingTime($request->title, $request->subtitle, $request->short_description, $request->description);

            $data->created          = date('Y-m-d');
            $data->title            = $request->title;
            $data->page_url         = $request->page_url;
            $data->subtitle         = $request->subtitle;
            $data->short_description= $request->short_description;
            $data->description      = $request->description;
            $data->read_time        = $readTime;

            $data->meta_title       = $request->meta_title;
            $data->meta_tag         = $request->meta_tag;
            $data->meta_description = $request->meta_description;

            if ($request->file('meta_image')) {
                if (file_exists($data->meta_image)) unlink($data->meta_image);
                $data->meta_image = uploadFile($request->file('meta_image'), 'public/uploads');
            }

            if (!empty ($request->file('featured_image'))) {
                if (file_exists($data->featured_image))
                    unlink($data->featured_image);
                $data->featured_image = uploadImage($request->file('featured_image'), 'public/uploads/Services');
            } else {
                $data->featured_image = $data->featured_image;
            }

            $data->save();

            flash()->addSuccess('Blog update successful.', 'Update');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Blog::find($id);

        if (file_exists($data->featured_image))
            unlink($data->featured_image);

        $data->delete();

        flash()->addSuccess('Blog delete successful.', 'Delete');

        return redirect()->route('admin.blog');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFeaturedImage(string $id)
    {
        $data = Blog::find($id);
        if (file_exists($data->featured_image))
            unlink($data->featured_image);

        $data->featured_image = null;

        $data->save();

        flash()->addSuccess('Featured image delete successful.', 'Delete');

        return redirect()->back();
    }
}
