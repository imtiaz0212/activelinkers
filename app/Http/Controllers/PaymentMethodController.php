<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->data['activeMenu'] = 'paymentMethod';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->data['results'] = PaymentMethod::all();

        return view('paymentMethod.index', $this->data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255',
            'public_key' => 'required|max:255',
            'secret_key' => 'required|max:255',
        ]);

        if ($validator->fails()) {

            flash()->addError('Invalid credential.');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new PaymentMethod;

        $data->name       = trim($request->name);
        $data->public_key = trim($request->public_key);
        $data->secret_key = trim($request->secret_key);

        $data->save();

        flash()->addSuccess('Payment method add successful.');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        if (!empty($request->id)) {

            $info = PaymentMethod::find($request->id);

            if (!empty($info)) {
                return response()->json([
                    'data'   => $info,
                    'status' => true,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'         => 'required',
            'name'       => 'required|max:255',
            'public_key' => 'required|max:255',
            'secret_key' => 'required|max:255',
            'mode'       => 'required',
            'status'     => 'required',
        ]);

        if ($validator->fails()) {

            flash()->addError('Invalid credential.');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = PaymentMethod::find($request->id);

        $data->name       = trim($request->name);
        $data->public_key = trim($request->public_key);
        $data->secret_key = trim($request->secret_key);
        $data->mode       = $request->mode;
        $data->status     = $request->status;

        $data->save();

        flash()->addSuccess('Payment method update successful.', 'Update');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        flash()->addSuccess('Payment method delete successful.', 'Delete');

        return redirect()->back();
    }
}
