<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{

    public function showResetForm(Request $request)
    {
        $tokenInfo = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (empty($tokenInfo)) {
             flash()->addError('Your reset token has expired.');
             return redirect()->route('admin.password.forgot');
        }

        $this->data['token'] = $request->token;

        return view('auth.passwords.reset', $this->data);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'    => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            flash()->addError('Invalid credential.');
            return back()->withErrors($validator);
        }

        $tokenInfo = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (empty($tokenInfo)) {
            flash()->addError('Your reset token has expired.');
            return redirect()->route('admin.password.forgot');
        }

        // update password
        Admin::where('email', $tokenInfo->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // delete token
        DB::table('password_reset_tokens')->where('email', $tokenInfo->email)->delete();

        flash()->addSuccess('New password add successful.');
        return redirect()->route('admin.login');
    }
}
