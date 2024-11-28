<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\SiteList;
use App\Models\Niche;
use Illuminate\Http\Request;

class SiteListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:sites,admin'])->only('index');
        $this->middleware(['permission:sites create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:sites edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:sites destroy,admin'])->only('destroy');

        $this->data['activeMenu'] = 'siteList';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results']   = SiteList::orderBy('traffic', 'desc')->paginate(20);
        $this->data['nicheList'] = Niche::all();

        return view('siteList.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['niche']       = Niche::all();
        $this->data['countryList'] = Country::select('id', 'name')->orderBy('name')->get();

        return view('siteList.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new SiteList;

        $data->created = date('Y-m-d');

        if (!empty($request->title)) {
            $data->title = $request->title;
        }

        if (!empty($request->url)) {
            $data->url       = $request->url;
            $data->check_url = removeHttp($request->url);
        }

        if (!empty($request->owner)) {
            $data->owner = $request->owner;
        }

        if (!empty($request->niche)) {
            $data->niche = json_encode($request->niche);
        }

        if (!empty($request->general_price)) {
            $data->general_price = $request->general_price;
        }

        if (!empty($request->other_price)) {
            $data->other_price = $request->other_price;
        }

        if (!empty($request->da)) {
            $data->da = $request->da;
        }

        if (!empty($request->pa)) {
            $data->pa = $request->pa;
        }

        if (!empty($request->dr)) {
            $data->dr = $request->dr;
        }

        if (!empty($request->ahref)) {
            $data->ahref_rank = $request->ahref;
        }

        if (!empty($request->traffic)) {
            $data->traffic = $request->traffic;
        }

        if (!empty($request->organic_keyword)) {
            $data->organic_keyword = $request->organic_keyword;
        }

        if (!empty($request->country_id)) {
            $data->country_id = $request->country_id;
        }

        if (!empty($request->file("attachment"))) {
            $data->image = uploadImage($request->file("attachment"), "public/uploads/websites");
        }

        $metaTitle = (!empty($request->meta_title) ? $request->meta_title : $request->title);

        $data->meta_title = $metaTitle;

        if (!empty($request->meta_tag)) {
            $data->meta_tag = $request->meta_tag;
        }

        if (!empty($request->meta_description)) {
            $data->meta_description = $request->meta_description;
        }

        $data->auto_update = isset($request->auto_update) ? 1 : 0;

        $data->save();

        // update api site id
        if (!empty($data->url) && $data->auto_update == 1) {
            $apiResponse = rankWebsite()->store($request->url);
            if(!empty($apiResponse->data)){
                $apiData = (object)$apiResponse->data;
                SiteList::where('id', $data->id)->update(['api_site_id' => $apiData->id]);
            }
        }

        flash()->addSuccess('Site List add successful.');

        // return redirect()->route('admin.siteList');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id = null)
    {
        $this->data['info'] = SiteList::find($id);

        $this->data['nicheList']   = Niche::all();
        $this->data['countryList'] = Country::select('id', 'name')->orderBy('name')->get();

        return view('siteList.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiteList $siteList)
    {
        $data = SiteList::find($request->id);

        if (!empty($request->title)) {
            $data->title = $request->title;
        }

        if (!empty($request->url)) {
            $data->url       = $request->url;
            $data->check_url = removeHttp($request->url);
        }

        if (!empty($request->owner)) {
            $data->owner = $request->owner;
        }

        if (!empty($request->niche)) {
            $data->niche = json_encode($request->niche);
        }

        if (!empty($request->general_price)) {
            $data->general_price = $request->general_price;
        }

        if (!empty($request->other_price)) {
            $data->other_price = $request->other_price;
        }

        if (!empty($request->da)) {
            $data->da = $request->da;
        }

        if (!empty($request->pa)) {
            $data->pa = $request->pa;
        }

        if (!empty($request->dr)) {
            $data->dr = $request->dr;
        }

        if (!empty($request->ahref)) {
            $data->ahref_rank = $request->ahref;
        }

        if (!empty($request->traffic)) {
            $data->traffic = $request->traffic;
        }

        if (!empty($request->organic_keyword)) {
            $data->organic_keyword = $request->organic_keyword;
        }

        if (!empty($request->country_id)) {
            $data->country_id = $request->country_id;
        }

        if (!empty($request->file("attachment"))) {

            if (file_exists($data->image)) {
                unlink($data->image);
            }

            $data->image = uploadImage($request->file("attachment"), "public/uploads/websites");
        }

        $metaTitle = (!empty($request->meta_title) ? $request->meta_title : $request->title);

        $data->meta_title = $metaTitle;

        if (!empty($request->meta_tag)) {
            $data->meta_tag = $request->meta_tag;
        }

        if (!empty($request->meta_description)) {
            $data->meta_description = $request->meta_description;
        }

        $data->auto_update = isset($request->auto_update) ? 1 : 0;

        $data->save();

        // update or delete api data
        if (!empty($request->url)) {
            if ($data->auto_update == 1) {
                if (!empty($data->api_site_id)) {
                    rankWebsite()->update($data->api_site_id, $request->url);
                } else {

                    $apiResponse = rankWebsite()->store($request->url);
                    if(!empty($apiResponse->data)){
                        $apiData = (object)$apiResponse->data;
                        SiteList::where('id', $data->id)->update(['api_site_id' => $apiData->id]);
                    }
                }
            } elseif (!empty($data->api_site_id)) {
                rankWebsite()->destroy($data->api_site_id);
                SiteList::where('id', $data->id)->update(['api_site_id' => null]);
            }
        }

        flash()->addSuccess('Site List Update successful.');

        return redirect()->route('admin.site-list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = SiteList::find($id);

        if (file_exists($data->image)) {
            unlink($data->image);
        }

        if (!empty($data->api_site_id)) {
            rankWebsite()->destroy($data->api_site_id);
            SiteList::where('id', $data->id)->update(['api_site_id' => null]);
        }

        $data->delete();

        flash()->addSuccess('Site List delete successful.', 'Delete');

        return redirect()->route('admin.site-list');
    }
}
