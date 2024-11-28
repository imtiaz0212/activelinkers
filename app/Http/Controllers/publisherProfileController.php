<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class publisherProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:publisher');
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $this->data['activeMenu'] = 'publisherProfile';
        $this->data['info']       = Publisher::find(Auth::user()->id);

        return view('publisher.profile', $this->data);
    }

    public function update(Request $request)
    {
        $data = Publisher::find(Auth::user()->id);

        $data->name       = $request->name;
        $data->email      = $data->email;
        $data->mobile     = $request->mobile;
        $data->address    = $request->address;

        if ($request->file('avatar')) {
            if (file_exists($data->avatar)) unlink($data->avatar);
            $data['avatar'] = uploadFile($request->file('avatar'), 'public/images/publisher');
        }

        $data->save();

        flash()->addSuccess('Profile Update Successful', 'Update');

        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $data = Publisher::find(Auth::user()->id);

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
