<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:settings,admin'])->only(['index', 'store', 'destroy']);

        $this->data['activeMenu'] = 'settings';

        Cache::forget('siteInfo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['info'] = getSiteInfo();

        return view('settings.index', $this->data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* site name */
        $data = Settings::firstOrNew(['meta_key' => 'site_name']);
        $data->meta_key = 'site_name';
        $data->meta_value = $request->site_name;
        $data->save();

        if (!empty ($request->file('login_bg'))) {

            $data = Settings::firstOrNew(['meta_key' => 'login_bg']);

            if (!empty ($data) && file_exists($data->meta_value))
            unlink($data->meta_value);

            $data->meta_key = 'login_bg';
            $data->meta_value = uploadFile($request->file('login_bg'), 'public/uploads', 1200, 250);
            $data->save();
        }

        if (!empty ($request->file('logo'))) {

            $data = Settings::firstOrNew(['meta_key' => 'logo']);

            if (!empty ($data) && file_exists($data->meta_value))
            unlink($data->meta_value);

            $data->meta_key = 'logo';
            $data->meta_value = uploadFile($request->file('logo'), 'public/uploads');
            $data->save();
        }

        if (!empty ($request->file('footer_logo'))) {

            $data = Settings::firstOrNew(['meta_key' => 'footer_logo']);

            if (!empty ($data) && file_exists($data->meta_value))
            unlink($data->meta_value);

            $data->meta_key = 'footer_logo';
            $data->meta_value = uploadImage($request->file('footer_logo'), 'public/uploads');
            $data->save();
        }

        if (!empty ($request->file('favicon'))) {

            $data = Settings::firstOrNew(['meta_key' => 'favicon']);

            if (!empty ($data) && file_exists($data->meta_value))
            unlink($data->meta_value);

            $data->meta_key = 'favicon';
            $data->meta_value = uploadFile($request->file('favicon'), 'public/uploads');
            $data->save();
        }

        $data = Settings::firstOrNew(['meta_key' => 'copyright']);
        $data->meta_key = 'copyright';
        $data->meta_value = $request->copyright;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'map_title']);
        $data->meta_key = 'map_title';
        $data->meta_value = $request->map_title;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'map']);
        $data->meta_key = 'map';
        $data->meta_value = $request->map;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'client_capital']);
        $data->meta_key = 'client_capital';
        $data->meta_value = $request->client_capital;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'founded_since']);
        $data->meta_key = 'founded_since';
        $data->meta_value = $request->founded_since;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'amazing_team']);
        $data->meta_key = 'amazing_team';
        $data->meta_value = $request->amazing_team;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'active_post']);
        $data->meta_key = 'active_post';
        $data->meta_value = $request->active_post;
        $data->save();

        // Statistics Demo Data Upload Here
        // $statistic = new Statistic;
        // $statistic = Statistic::first();
        // $statistic->client_capital  = $request->client_capital;
        // $statistic->founded_since   = $request->founded_since;
        // $statistic->amazing_team    = $request->amazing_team;
        // $statistic->active_post     = $request->active_post;

        // $statistic->save();

        $data = Settings::firstOrNew(['meta_key' => 'google_plus']);
        $data->meta_key = 'google_plus';
        $data->meta_value = $request->google_plus;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'facebook']);
        $data->meta_key = 'facebook';
        $data->meta_value = $request->facebook;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'twitter']);
        $data->meta_key = 'twitter';
        $data->meta_value = $request->twitter;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'instagram']);
        $data->meta_key = 'instagram';
        $data->meta_value = $request->instagram;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'linkedin']);
        $data->meta_key = 'linkedin';
        $data->meta_value = $request->linkedin;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'youtube']);
        $data->meta_key = 'youtube';
        $data->meta_value = $request->youtube;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'meta_title']);
        $data->meta_key = 'meta_title';
        $data->meta_value = $request->meta_title;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'meta_tag']);
        $data->meta_key = 'meta_tag';
        $data->meta_value = $request->meta_tag;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'meta_description']);
        $data->meta_key = 'meta_description';
        $data->meta_value = $request->meta_description;
        $data->save();

        if (!empty ($request->file('meta_image'))) {

            $data = Settings::firstOrNew(['meta_key' => 'meta_image']);

            if (!empty ($data) && file_exists($data->meta_value))
                unlink($data->meta_value);

            $data->meta_key = 'meta_image';
            $data->meta_value = uploadFile($request->file('meta_image'), 'public/uploads');
            $data->save();
        }

        $data = Settings::firstOrNew(['meta_key' => 'mobile']);
        $data->meta_key = 'mobile';
        $data->meta_value = $request->mobile;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'skype']);
        $data->meta_key = 'skype';
        $data->meta_value = $request->skype;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'whatsapp']);
        $data->meta_key = 'whatsapp';
        $data->meta_value = $request->whatsapp;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'telephone']);
        $data->meta_key = 'telephone';
        $data->meta_value = $request->telephone;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'fax']);
        $data->meta_key = 'fax';
        $data->meta_value = $request->fax;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'email']);
        $data->meta_key = 'email';
        $data->meta_value = $request->email;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'location']);
        $data->meta_key = 'location';
        $data->meta_value = $request->location;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'us_location']);
        $data->meta_key = 'us_location';
        $data->meta_value = $request->us_location;
        $data->save();

        $data = Settings::firstOrNew(['meta_key' => 'about_us']);
        $data->meta_key = 'about_us';
        $data->meta_value = $request->about_us;
        $data->save();

        Cache::forget('siteInfo');

        flash()->addSuccess('Settings save successful.', 'Success');
        return redirect()->back();
    }

    public function destroy(string $mkey)
    {
        if (!empty ($mkey)) {

            $data = Settings::where('meta_key', $mkey)->first();
            if (file_exists($data->meta_value))
                unlink($data->meta_value);
            $data->delete();

            flash()->addSuccess(strFilter($mkey) . ' delete successful.', 'Delete');
            return redirect()->back();
        }
    }

    public function getStatistics(Request $request)
    {

        return Statistic::first();
    }
}
