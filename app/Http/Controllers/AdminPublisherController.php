<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminPublisherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->data['activeMenu'] = 'publisherList';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Publisher::all();

        return view('publisher.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publisher.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $data = new Publisher;

        $data->name     = $request->name;
        $data->email    = $request->email;
        $data->mobile   = $request->mobile;
        $data->address  = $request->address;
        $data->password = Hash::make($request->password);

        $fileInfo = $request->file('avatar');
        if ($fileInfo) {
            $data->avatar = uploadFile($fileInfo, 'public/uploads/publisher');
        }

        $data->save();

        flash()->addSuccess('Publisher create successful.', 'Success');

        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['info'] = Publisher::find($id);

        return view('publisher.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $existData = Publisher::where('email', $request->email)->where('id', '!=', $id)->first();
        if (!empty($existData)) {
            flash()->addWarning('This email address already exists.', 'Warning');
            return redirect()->back();
        }

        $data = Publisher::find($id);

        $data->name     = $request->name;
        $data->email    = $request->email;
        $data->mobile   = $request->mobile;
        $data->address  = $request->address;
        $data->password = $data->password;

        $fileInfo = $request->file('avatar');
        if ($fileInfo) {
            if (file_exists($data->avatar)) unlink($data->avatar);
            $data->avatar = uploadFile($fileInfo, 'public/uploads/users');
        }

        $data->save();

        flash()->addSuccess('Publisher update successful.', 'Update');

        return redirect()->route('publisher.user');
    }

    public function updatePassword(Request $request, $id)
    {
        $data = Publisher::find($id);

        if (Hash::check($request->current_password, $data->password)) {

            $validator = Validator::make($request->all(), ['password' => ['required', 'string', 'min:6', 'confirmed']]);

            if ($validator->fails()) {
                flash()->addError('Password and confirm password are not same.', 'Invalid');
                return redirect()->back();
            }

            $data->name     = $data->name;
            $data->email    = $data->email;
            $data->password = Hash::make($request->password);

            $data->save();

            flash()->addSuccess('Password Update Successful', 'Update');

            return redirect()->back();
        }

        flash()->addError('Invalid current password.', 'Invalid');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Publisher::find($id);

        if ($data->privilege == 'publisher') {
            $data->delete();


            flash()->addSuccess('User delete successful.', 'Delete');
        } else {
            flash()->addError('You can\'t delete this publisher.', 'Error');
        }


        return redirect()->route('publisher.user');
    }
}
