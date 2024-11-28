<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\LinkList;
use App\Models\Niche;
use App\Models\LinkPrice;
use App\Models\LinkVisitedCountry;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class LinkListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->data['activeMenu'] = 'link_list';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = LinkList::with('linkPrice', 'countryList')->orderBy('created_at', 'desc')->get();

        $this->data['nicheList'] = Niche::all();

        return view('link_list.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $this->data['publisher'] = Publisher::all();
        
        $this->data['niche'] = Niche::all();

        $this->data['countries'] = DB::table('countries')->get();

        
        return view('link_list.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());

        $publisher = Publisher::where('id', $request->publisher_id)->first();

        $data = new LinkList;
        
        // echo date("Y-m-d H:i:s", strtotime("+1 years", strtotime('2014-05-22 10:35:10'))); //2015-05-22 10:35:10
        $productId = 'PIT'.date('ym').rand(1001, 9999);

        do {
            $productId = 'PIT'.date('ym').rand(1001, 9999);
        }while (!empty(LinkList::where('product_id', $productId)->first()));
        
        
        $data->created = date('Y-m-d');

        $data->privilege = $publisher->privilege;

        $data->product_id = $productId;

        if(!empty($request->title)) {
            $data->title = $request->title;
        }

        if(!empty($request->url)) {
            $data->url  = $request->url;
        }

        if(!empty($request->publisher_id)) {
            $data->publisher_id = $request->publisher_id;
        }

        if(!empty($request->niche)) {
            $data->niche = json_encode($request->niche);
        }

        if(!empty($request->description)) {
            $data->description = $request->description;
        }

        if(!empty($request->da)) {
            $data->da   = $request->da;
        }

        if(!empty($request->pa)) {
            $data->pa   = $request->pa;
        }

        if(!empty($request->dr)) {
            $data->dr   = $request->dr;
        }

        if(!empty($request->ahref)) {
            $data->ahref_rank = $request->ahref;
        }

        if(!empty($request->traffic)) {
            $data->traffic = $request->traffic;
        }

        if(!empty($request->organic_keyword)) {
            $data->organic_keyword  = $request->organic_keyword;
        }

        if(!empty($request->cf)) {
            $data->cf   = $request->cf;
        }

        if(!empty($request->tf)) {
            $data->tf   = $request->tf;
        }

        if(!empty($request->direct)) {
            $data->direct = $request->direct;
        }

        if(!empty($request->organic_search)) {
            $data->organic_search  = $request->organic_search;
        }

        if(!empty($request->social)) {
            $data->social = $request->social;
        }

        if(!empty($request->link_type)) {
            $data->link_type = $request->link_type;
        }

        if(!empty($request->link_validity)) {
            $data->link_validity = $request->link_validity;
        }

        if($request->homepage_link == 'yes') {
            $data->homepage_link    = 'yes';
        } else {
            $data->homepage_link    = 'no';
        }

        if($request->sidebar_link == 'yes') {
            $data->sidebar_link = 'yes';
        } else {
            $data->sidebar_link = 'no';
        }

        if($request->footer_link == 'yes') {
            $data->footer_link = 'yes';
        } else {
            $data->footer_link = 'no';
        }
        
        if($request->cbd == 'yes'){
            $data->cbd = 'yes';
        } else {
            $data->cbd = 'no';
        }
        
        if($request->crypto == 'yes') {
            $data->crypto = 'yes';
        } else {
            $data->crypto = 'no';
        }

        if($request->casino == 'yes') {
            $data->casino = 'yes';
        } else {
            $data->casino = 'no';
        }

        if ($request->file('image')) {
            $data->images = uploadFile($request->file('image'), 'public/uploads/link');
        }
        
        $data->save();

        // Link Price List Add Here

        $price = new LinkPrice;
        
        $price->product_id = $productId;

        if(!empty($request->regular_price) && $request->regular_price > 0) {
            $price->regular_price           = $request->regular_price;
        }
        if(!empty($request->sale_price) && $request->sale_price > 0) {
            $price->sale_price              = $request->sale_price;
        }
        if(!empty($request->owner_price) && $request->owner_price > 0) {
            $price->owner_price             = $request->owner_price;
        }
        if(!empty($request->merchant_cbd_price) && $request->merchant_cbd_price > 0) {
            $price->merchant_cbd_price      = $request->merchant_cbd_price;
        }
        if(!empty($request->owner_cbd_price) && $request->owner_cbd_price > 0) {
            $price->owner_cbd_price         = $request->owner_cbd_price;
        }
        if(!empty($request->merchant_crypto_price) && $request->merchant_crypto_price > 0) {
            $price->merchant_crypto_price   = $request->merchant_crypto_price;
        }
        if(!empty($request->owner_crypto_price) && $request->owner_crypto_price > 0) {
            $price->owner_crypto_price      = $request->owner_crypto_price;
        }
        if(!empty($request->merchant_casino_price) && $request->merchant_casino_price > 0) {
            $price->merchant_casino_price   = $request->merchant_casino_price;
        }
        if(!empty($request->owner_casino_price) && $request->owner_casino_price > 0) {
            $price->owner_casino_price      = $request->owner_casino_price;
        }
        if(!empty($request->merchant_homepage_price) && $request->merchant_homepage_price > 0) {
            $price->merchant_homepage_price = $request->merchant_homepage_price;
        }
        if(!empty($request->owner_homepage_price) && $request->owner_homepage_price > 0) {
            $price->owner_homepage_price    = $request->owner_homepage_price;
        }
        if(!empty($request->merchant_sidebar_price) && $request->merchant_sidebar_price > 0) {
            $price->merchant_sidebar_price  = $request->merchant_sidebar_price;
        }
        if(!empty($request->owner_sidebar_price) && $request->owner_sidebar_price > 0) {
            $price->owner_sidebar_price     = $request->owner_sidebar_price;
        }
        if(!empty($request->merchant_footer_price) && $request->merchant_footer_price > 0) {
            $price->merchant_footer_price   = $request->merchant_footer_price;
        }
        if(!empty($request->owner_footer_price) && $request->owner_footer_price > 0) {
            $price->owner_footer_price      = $request->owner_footer_price;
        }
        
        $price->save();

        // Most Visited Country & Percent Add Here

        $link_id = $data->id;
        foreach($request->country_id as $key => $country_id) {
            $visit = new LinkVisitedCountry;

            $visit['link_id'] = $link_id;
            $visit['product_id'] = $productId;
            $visit['country_id'] = $country_id;
            $visit['percent'] = $request->percent[$key];
            
            $visit->save();
        }
        

        flash()->addSuccess('Link Placement add successful.');

        return redirect()->route('admin.link_list');
    }

    /**
     * Show the form for View the specified resource.
     */
    public function show(string $id)
    {
        $this->data['info'] = $info = LinkList::with('linkPrice', 'publisher')->find($id);

        $this->data['nicheList'] = Niche::all();

        $this->data['country_percent']  = DB::table('link_visited_countries')->leftJoin('countries', 'countries.id', '=', 'link_visited_countries.country_id')
                                            ->select('link_visited_countries.*', 'countries.name as country_name', 'countries.nicename as country_nicename', 'countries.iso as country_iso')
                                            ->where('link_visited_countries.link_id', $id)->whereNull('link_visited_countries.deleted_at')->get();

        return view('link_list.show', $this->data);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['info'] = LinkList::with('linkPrice', 'publisher')->find($id);

        $this->data['nicheList'] = Niche::all();

        $this->data['publisher'] = Publisher::all();

        $this->data['countries'] = DB::table('countries')->get();

        $this->data['country_percent']  = DB::table('link_visited_countries')->leftJoin('countries', 'countries.id', '=', 'link_visited_countries.country_id')
                                            ->select('link_visited_countries.*', 'countries.name as country_name', 'countries.nicename as country_nicename', 'countries.iso as country_iso')
                                            ->where('link_visited_countries.link_id', $id)->whereNull('link_visited_countries.deleted_at')->get();

        return view('link_list.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!empty($request->id)) {
            $publisher = Publisher::where('id', $request->publisher_id)->first();
            
            $data = LinkList::find($request->id);
            
            // echo date("Y-m-d H:i:s", strtotime("+1 years", strtotime('2014-05-22 10:35:10'))); //2015-05-22 10:35:10
                
            $data->privilege = $publisher->privilege;
    
            $data->product_id = $request->product_id;
    
            if(!empty($request->title)) {
                $data->title = $request->title;
            }
    
            if(!empty($request->url)) {
                $data->url  = $request->url;
            }
    
            if(!empty($request->publisher_id)) {
                $data->publisher_id = $request->publisher_id;
            }
    
            if(!empty($request->niche)) {
                $data->niche = json_encode($request->niche);
            }
    
            if(!empty($request->description)) {
                $data->description = $request->description;
            }
    
            if(!empty($request->da)) {
                $data->da   = $request->da;
            }
    
            if(!empty($request->pa)) {
                $data->pa   = $request->pa;
            }
    
            if(!empty($request->dr)) {
                $data->dr   = $request->dr;
            }
    
            if(!empty($request->ahref)) {
                $data->ahref_rank = $request->ahref;
            }
    
            if(!empty($request->traffic)) {
                $data->traffic = $request->traffic;
            }
    
            if(!empty($request->organic_keyword)) {
                $data->organic_keyword  = $request->organic_keyword;
            }
    
            if(!empty($request->cf)) {
                $data->cf   = $request->cf;
            }
    
            if(!empty($request->tf)) {
                $data->tf   = $request->tf;
            }
    
            if(!empty($request->direct)) {
                $data->direct = $request->direct;
            }
    
            if(!empty($request->organic_search)) {
                $data->organic_search  = $request->organic_search;
            }
    
            if(!empty($request->social)) {
                $data->social = $request->social;
            }
    
            if(!empty($request->link_type)) {
                $data->link_type = $request->link_type;
            }
    
            if(!empty($request->link_validity)) {
                $data->link_validity = $request->link_validity;
            }
    
            if($request->homepage_link == 'yes') {
                $data->homepage_link    = 'yes';
            } else {
                $data->homepage_link    = 'no';
            }
    
            if($request->sidebar_link == 'yes') {
                $data->sidebar_link = 'yes';
            } else {
                $data->sidebar_link = 'no';
            }
    
            if($request->footer_link == 'yes') {
                $data->footer_link = 'yes';
            } else {
                $data->footer_link = 'no';
            }
            
            if($request->cbd == 'yes'){
                $data->cbd = 'yes';
            } else {
                $data->cbd = 'no';
            }
            
            if($request->crypto == 'yes') {
                $data->crypto = 'yes';
            } else {
                $data->crypto = 'no';
            }
    
            if($request->casino == 'yes') {
                $data->casino = 'yes';
            } else {
                $data->casino = 'no';
            }


            if ($request->file('image')) {
                if (file_exists($data->images)) unlink($data->images);
                $data->images = uploadFile($request->file('image'), 'public/uploads/link');
            }
            
            $data->save();

            // Link Price List Update Here

            $price = LinkPrice::where('product_id', $request->product_id)->first();
            
            $price->product_id = $request->product_id;
    
            if(!empty($request->regular_price) && $request->regular_price > 0) {
                $price->regular_price           = $request->regular_price;
            }
            if(!empty($request->sale_price) && $request->sale_price > 0) {
                $price->sale_price              = $request->sale_price;
            }
            if(!empty($request->owner_price) && $request->owner_price > 0) {
                $price->owner_price             = $request->owner_price;
            }
            if(!empty($request->merchant_cbd_price) && $request->merchant_cbd_price > 0) {
                $price->merchant_cbd_price      = $request->merchant_cbd_price;
            }
            if(!empty($request->owner_cbd_price) && $request->owner_cbd_price > 0) {
                $price->owner_cbd_price         = $request->owner_cbd_price;
            }
            if(!empty($request->merchant_crypto_price) && $request->merchant_crypto_price > 0) {
                $price->merchant_crypto_price   = $request->merchant_crypto_price;
            }
            if(!empty($request->owner_crypto_price) && $request->owner_crypto_price > 0) {
                $price->owner_crypto_price      = $request->owner_crypto_price;
            }
            if(!empty($request->merchant_casino_price) && $request->merchant_casino_price > 0) {
                $price->merchant_casino_price   = $request->merchant_casino_price;
            }
            if(!empty($request->owner_casino_price) && $request->owner_casino_price > 0) {
                $price->owner_casino_price      = $request->owner_casino_price;
            }
            if(!empty($request->merchant_homepage_price) && $request->merchant_homepage_price > 0) {
                $price->merchant_homepage_price = $request->merchant_homepage_price;
            }
            if(!empty($request->owner_homepage_price) && $request->owner_homepage_price > 0) {
                $price->owner_homepage_price    = $request->owner_homepage_price;
            }
            if(!empty($request->merchant_sidebar_price) && $request->merchant_sidebar_price > 0) {
                $price->merchant_sidebar_price  = $request->merchant_sidebar_price;
            }
            if(!empty($request->owner_sidebar_price) && $request->owner_sidebar_price > 0) {
                $price->owner_sidebar_price     = $request->owner_sidebar_price;
            }
            if(!empty($request->merchant_footer_price) && $request->merchant_footer_price > 0) {
                $price->merchant_footer_price   = $request->merchant_footer_price;
            }
            if(!empty($request->owner_footer_price) && $request->owner_footer_price > 0) {
                $price->owner_footer_price      = $request->owner_footer_price;
            }
            
            $price->save();
    
            //Most Visited Country & Percent Update Here

            foreach($request->country_id as $key => $country_id) {

                $visit = LinkVisitedCountry::find($request->country[$key]);
                
                $visit['link_id']    = $request->id;
                $visit['product_id'] = $request->product_id;
                $visit['country_id'] = $country_id;
                $visit['percent']    = $request->percent[$key];
                
                $visit->save();
            }

            flash()->addSuccess('Link update successful.', 'Update');
        }

        return redirect()->route('admin.link_list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = LinkList::find($id);

        if (file_exists($data->images)) unlink($data->images);

        $data->delete();

        flash()->addSuccess('Link delete successful.', 'Delete');

        return redirect()->route('admin.link_list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFeaturedImage(string $id)
    {
        $data = LinkList::find($id);
        if (file_exists($data->images)) unlink($data->images);
        
        $data->images = null;

        $data->save();

        flash()->addSuccess('Link image delete successful.', 'Delete');

        return redirect()->back();
    }
}
