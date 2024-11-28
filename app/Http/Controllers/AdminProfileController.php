<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $this->data['activeMenu'] = 'adminProfile';
        $this->data['info']       = Admin::find(Auth::user()->id);

        $this->data['notificationActive'] = 'active';

        return view('adminpanel.profile', $this->data);
    }

    public function update(Request $request)
    {
        $data = Admin::find(Auth::user()->id);

        $data->name       = $request->name;
        $data->email      = $data->email;
        $data->mobile     = $request->mobile;
        $data->address    = $request->address;

        if ($request->file('avatar')) {
            if (file_exists($data->avatar)) unlink($data->avatar);
            $data['avatar'] = uploadFile($request->file('avatar'), 'public/images/users');
        }

        $data->save();

        flash()->addSuccess('Profile Update Successful', 'Update');

        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $data = Admin::find(Auth::user()->id);

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
}
