<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:team,admin'])->only('index');
        $this->middleware(['permission:team create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:team edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:team destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'team';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Team::orderBy('created_at', 'desc')->get();

        return view('teams.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Team;

        $data->created = date('Y-m-d');
        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->designation = $request->designation;
        $data->department = $request->department;
        $data->joining_date = $request->joining_date;
        $data->description = $request->description;

        if ($request->file('featured_image')) {
            $data->image = uploadFile($request->file('featured_image'), 'public/uploads/team');
        }

        $data->save();

        flash()->addSuccess('Team add successful.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['info'] = Team::find($id);

        return view('teams.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty($request->id)) {

            $data = Team::find($request->id);

            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->designation = $request->designation;
            $data->department = $request->department;
            $data->joining_date = $request->joining_date;
            $data->description = $request->description;

            $imagePath = $request->file('featured_image');
            if (!empty($imagePath)) {
                if (file_exists($data->image))
                    unlink($data->image);
                $data->image = uploadImage($imagePath, 'public/uploads/team');
            }

            $data->save();
            flash()->addSuccess('Team update successful.', 'Update');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Team::find($id);

        if (file_exists($data->image))
            unlink($data->image);

        $data->delete();

        flash()->addSuccess('Team delete successful.', 'Delete');

        return redirect()->route('admin.teams');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroyFeaturedImage(string $id)
    {
        $data = Team::find($id);
        if (file_exists($data->image))
            unlink($data->image);

        $data->name = $data->name;
        $data->slug = $data->slug;
        $data->phone = $data->phone;
        $data->email = $data->email;
        $data->designation = $data->designation;
        $data->department = $data->department;
        $data->description = $data->description;
        $data->image = null;

        $data->save();

        flash()->addSuccess('Image delete successful.', 'Delete');

        return redirect()->back();
    }
}
