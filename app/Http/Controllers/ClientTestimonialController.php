<?php

namespace App\Http\Controllers;

use App\Models\ClientTestimonial;
use Illuminate\Http\Request;

class ClientTestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:client testimonial,admin'])->only('index');
        $this->middleware(['permission:client testimonial create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:client testimonial edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:client testimonial destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'clientTestimonial';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = ClientTestimonial::orderBy('created_at', 'desc')->get();

        return view('client-testimonial.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client-testimonial.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new ClientTestimonial;

        $data->created = date('Y-m-d');
        $data->name = $request->name;
        $data->designation = $request->designation;
        $data->description = $request->description;

        if ($request->star > 5) {
            $data->star = 5;
        } else {
            $data->star = $request->star;
        }

        if ($request->file('avatar')) {
            $data->avatar = uploadFile($request->file('avatar'), 'public/uploads/client-testimonial');
        }

        $data->save();

        flash()->addSuccess('Client Testimonial add successful.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientTestimonial $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['info'] = ClientTestimonial::find($id);

        return view('client-testimonial.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty ($request->id)) {

            $data = ClientTestimonial::find($request->id);

            $data->created = date('Y-m-d');
            $data->name = $request->name;
            $data->designation = $request->designation;
            $data->description = $request->description;

            if ($request->star > 5) {
                $data->star = 5;
            } else {
                $data->star = $request->star;
            }

            $imagePath = $request->file('avatar');
            if (!empty ($imagePath)) {
                if (file_exists($data->avatar))
                    unlink($data->avatar);
                $data->avatar = uploadImage($imagePath, 'public/uploads/client-testimonial');
            }

            $data->save();
            flash()->addSuccess('Client Testimonial update successful.', 'Update');
        }
        return redirect()->route('admin.client-testimonial');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ClientTestimonial::find($id);

        if (file_exists($data->avatar))
            unlink($data->avatar);

        $data->delete();

        flash()->addSuccess('Client Testimonial delete successful.', 'Delete');

        return redirect()->route('admin.client-testimonial');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroyFeaturedImage(string $id)
    {
        $data = ClientTestimonial::find($id);

        if (file_exists($data->avatar))
            unlink($data->avatar);

        $data->avatar = null;

        $data->save();

        flash()->addSuccess('Client Testimonial Image delete successful.', 'Delete');

        return redirect()->back();
    }
}
