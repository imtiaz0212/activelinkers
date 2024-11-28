<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomePageController extends Controller
{
    public function __construct()
    {
        Cache::forget('sectionData');
        $this->middleware('auth:admin');
        $this->data['activeMenu'] = 'pages';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['activeSubMenu'] = "home-page";

        $this->data['results']  = Section::where('page', 'home')->get();

        return view('section.home-page', $this->data);
    }

    /**
     * update hero section data
     */
    public function updateHero(Request $request)
    {
        $section          = Section::firstOrNew(['page' => 'home', 'section' => 'hero']);
        $section->page    = 'home';
        $section->section = 'hero';

        $content         = $request->hero;
        $existingContent = json_decode($section->content);

        if (!empty($request->heroImage)) {
            if (!empty($existingContent->image) && file_exists($existingContent->image)) {
                unlink($existingContent->image);
            }
            $content['image'] = uploadImage($request->heroImage, "public/uploads/section");
        } elseif (!empty($existingContent->image)) {
            $content['image'] = $existingContent->image;
        }

        $section->content = json_encode($content);
        $section->save();

        flash()->addSuccess('Hero section update successfully.');
        return redirect()->route('admin.home-page');
    }

    /**
     * update statistics section data
     */
    public function updateStatistics(Request $request)
    {
        $section          = Section::firstOrNew(['page' => 'home', 'section' => 'statistics']);
        $section->page    = 'home';
        $section->section = 'statistics';

        $content         = $request->statistics;
        $existingContent = json_decode($section->content);

        if (!empty($request->statisticsImage)) {
            if (!empty($existingContent->image) && file_exists($existingContent->image)) {
                unlink($existingContent->image);
            }
            $content['image'] = uploadImage($request->statisticsImage, "public/uploads/section");
        } elseif (!empty($existingContent->image)) {
            $content['image'] = $existingContent->image;
        }

        $section->content = json_encode($content);
        $section->save();

        flash()->addSuccess('Statistics section update successfully.');
        return redirect()->route('admin.home-page');
    }

    /**
     * update hero section data
     */
    public function updateChooseUs(Request $request)
    {
        $section          = Section::firstOrNew(['page' => 'home', 'section' => 'chooseUs']);
        $section->page    = 'home';
        $section->section = 'chooseUs';

        $content         = $request->chooseUs;
        $existingContent = json_decode($section->content);

        if (!empty($request->chooseUsImage)) {
            if (!empty($existingContent->image) && file_exists($existingContent->image)) {
                unlink($existingContent->image);
            }
            $content['image'] = uploadImage($request->chooseUsImage, "public/uploads/section");
        } elseif (!empty($existingContent->image)) {
            $content['image'] = $existingContent->image;
        }

        $section->content = json_encode($content);
        $section->save();

        flash()->addSuccess('Choose Us section update successfully.');
        return redirect()->route('admin.home-page');
    }

    /**
     * update hero section data
     */
    public function updateCta(Request $request)
    {
        $section          = Section::firstOrNew(['page' => 'home', 'section' => 'cta']);
        $section->page    = 'home';
        $section->section = 'cta';
        $section->content = json_encode($request->cta);
        $section->save();

        flash()->addSuccess('CAR section update successfully.');
        return redirect()->route('admin.home-page');
    }
}
