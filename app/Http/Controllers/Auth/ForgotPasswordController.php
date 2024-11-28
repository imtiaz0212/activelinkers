<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordEmail;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{

    /**
     * show forgot form
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }


    /**
     * send reset email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|max:255'
        ]);

        $info = Admin::where('email', $request->email)->first();

        if (empty($info)) {
            flash()->addWarning('We can\'t fined your email.');
            return redirect()->back();
        }

        $token = Str::random(65);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => date('Y-m-d H:i:s')]
        );

        Mail::to($info->email)->send(new ForgotPasswordEmail(['name' => $info->name, 'token' => $token]));

        flash()->addSuccess('Password reset link has been sent to your email.');
        return redirect()->back();
    }
}
