<?php

namespace App\Http\Controllers;

use App\Models\LinkList;
use App\Models\Niche;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class PublisherLinkListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:publisher');

        $this->data['activeMenu'] = 'link_list';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->data['results'] = LinkList::with('linkPrice', 'countryList')->where('publisher_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        $this->data['nicheList'] = Niche::all();

        return view('publisherpanel.link_list', $this->data);
    }

    /**
     * Show the form for View the specified resource.
     */
    public function show(string $id)
    {
        $this->data['info'] = LinkList::with('linkPrice', 'publisher')->find($id);

        $this->data['nicheList'] = Niche::all();

        $this->data['country_percent']  = DB::table('link_visited_countries')->leftJoin('countries', 'countries.id', '=', 'link_visited_countries.country_id')
                                            ->select('link_visited_countries.*', 'countries.name as country_name', 'countries.nicename as country_nicename', 'countries.iso as country_iso')
                                            ->where('link_visited_countries.link_id', $id)->whereNull('link_visited_countries.deleted_at')->get();

        return view('publisherpanel.link_show', $this->data);
    }

}
