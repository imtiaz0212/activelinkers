<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:about us,admin'])->only(['index', 'store', 'destroyFeaturedImage']);

        $this->data['activeMenu'] = 'pages';
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['activeSubMenu'] = 'about-us';

        $this->data['info'] = AboutUs::first();

        return view('about-us.index', $this->data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = new AboutUs;
        $data = AboutUs::find($request->id);

        $data->created          = date('Y-m-d');
        $data->title            = $request->title;
        $data->page_url         = $request->page_url;
        $data->reach            = $request->reach;
        $data->reach_percent    = $request->reach_percent;
        $data->short_description= $request->short_description;
        $data->description      = $request->description;

        $data->meta_title       = $request->meta_title;
        $data->meta_tag         = $request->meta_tag;
        $data->meta_description = $request->meta_description;

        $advantage = [];
        if (!empty ($request->advantage_title)) {
            foreach ($request->advantage_title as $key => $title) {
                $item               = [];
                $item['title']      = $title;
                $item['icon']       = $request->advantage_icon[$key];
                $item['description']= $request->advantage_discription[$key];
                array_push($advantage, (object) $item);
            }
        }
        $data->advantage = json_encode($advantage);

        if ($request->file('featured_image')) {
            if (file_exists($data->images)) unlink($data->images);
            $data->images = uploadFile($request->file('featured_image'), 'public/uploads');
        }

        if ($request->file('meta_image')) {
            if (file_exists($data->meta_image)) unlink($data->meta_image);
            $data->meta_image = uploadFile($request->file('meta_image'), 'public/uploads');
        }

        $data->save();

        flash()->addSuccess('Package add successful.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFeaturedImage(string $id)
    {
        $data = AboutUs::find($id);

        if (file_exists($data->images))
            unlink($data->images);

        $data->images = null;

        $data->save();

        flash()->addSuccess('Featured image delete successful.', 'Delete');

        return redirect()->back();
    }

}
