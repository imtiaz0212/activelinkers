<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:admins,admin'])->only('index');
        $this->middleware(['permission:admins create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:admins edit,admin'])->only(['edit', 'update', 'updatePassword']);
        $this->middleware(['permission:admins destroy,admin'])->only('destroy');

        $this->data['roleList'] = Role::all();
        $this->data['activeMenu'] = 'admin';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Admin::all();

        return view('admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $data = new Admin;

        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->password = Hash::make($request->password);

        $fileInfo = $request->file('avatar');
        if ($fileInfo) {
            $data->avatar = uploadFile($fileInfo, 'public/uploads/admin');
        }

        $data->save();

        $data->assignRole($request->role);

        flash()->addSuccess('Admin create successful.', 'Success');

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
        $this->data['info'] = Admin::find($id);

        return view('admin.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $existData = Admin::where('email', $request->email)->where('id', '!=', $id)->first();
        if (!empty ($existData)) {
            flash()->addWarning('This email address already exists.', 'Warning');
            return redirect()->back();
        }
        $data = Admin::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->password = $data->password;

        $fileInfo = $request->file('avatar');
        if ($fileInfo) {
            if (file_exists($data->avatar))
                unlink($data->avatar);
            $data->avatar = uploadFile($fileInfo, 'public/uploads/users');
        }

        $data->save();

        $data->syncRoles($request->role);

        flash()->addSuccess('Admin update successful.', 'Update');

        return redirect()->route('admin.user');
    }

    public function updatePassword(Request $request, $id)
    {
        $data = Admin::find($id);

        if (Hash::check($request->current_password, $data->password)) {

            $validator = Validator::make($request->all(), ['password' => ['required', 'string', 'min:6', 'confirmed']]);

            if ($validator->fails()) {
                flash()->addError('Password and confirm password are not same.', 'Invalid');
                return redirect()->back();
            }

            $data->name = $data->name;
            $data->email = $data->email;
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
        $data = Admin::find($id);

        if ($data->privilege == 'admin') {
            $data->delete();


            flash()->addSuccess('User delete successful.', 'Delete');
        } else {
            flash()->addError('You can\'t delete this admin.', 'Error');
        }


        return redirect()->route('admin.user');
    }
}
