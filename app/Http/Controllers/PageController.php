<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:pages,admin'])->only('index');
        $this->middleware(['permission:pages create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:pages edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:pages destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'pages';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $page_url)
    {
        $this->data['activeSubMenu'] = $page_url;

        $this->data['info'] = Page::where('page_url', $page_url)->first();

        if (empty($this->data['info'])) return redirect('admin.dashboard');

        return view('pages.edit', $this->data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $checkExists = Page::where('page_url', $request->page_url)->whereNotIn('id', [$id])->first();

        if (!empty ($checkExists) && !empty ($request->title)) {

            flash()->addError('This page url already exists.', 'Error');

            return redirect()->back();
        }

        $data = Page::find($id);

        $data->title            = $request->title;
        $data->page_url         = $data->page_url;
        $data->subtitle         = $request->subtitle;
        $data->description      = $request->description;
        $data->status           = $data->status;
        $data->meta_title       = $request->meta_title;
        $data->meta_tag         = $request->meta_tag;
        $data->meta_description = $request->meta_description;

        if ($request->file('featured_image')) {
            if (file_exists($data->featured_image))
                unlink($data->featured_image);
            $data->featured_image = uploadFile($request->file('featured_image'), 'public/uploads/featuredImage');
        }

        $data->save();

        flash()->addSuccess('Page add successful.', "Update");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Page::find($id);
        if (file_exists($data->featured_image))
            unlink($data->featured_image);
        $data->delete();

        flash()->addSuccess('Page delete successful.', 'Delete');

        return redirect()->route('admin.page');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFeaturedImage(string $id)
    {
        $data = Page::find($id);
        if (file_exists($data->featured_image))
            unlink($data->featured_image);

        $data->title          = $data->title;
        $data->page_url       = strSlug($data->page_url);
        $data->description    = $data->description;
        $data->status         = $data->status;
        $data->featured_image = null;

        $data->save();

        flash()->addSuccess('Featured image delete successful.', 'Delete');

        return redirect()->back();
    }
}
