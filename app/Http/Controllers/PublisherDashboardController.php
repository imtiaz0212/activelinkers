<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublisherDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:publisher');

        $this->data['activeMenu'] = 'dashboard';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['info']       = Publisher::find(Auth::user()->id);
        
        return view('layouts.backend-partial.dashboard', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
