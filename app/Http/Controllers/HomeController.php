<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Service;
use App\Models\NewsLatter;
use App\Models\AboutUs;
use App\Models\Team;
use App\Models\Admin;
use App\Models\EmailFrom;
use App\Models\ClientTestimonial;
use App\Models\Information;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\SiteList;
use App\Models\Niche;
use App\Models\ContactUs;
use App\Models\Country;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use \Mpdf\Mpdf as PDF;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->data['menu']      = "";
        $this->data['siteTitle'] = "";

        $this->data['headerServiceList'] = Service::with('serviceCategory')->limit(5)->get();

        $this->data['userInfo'] = Admin::get();

        $this->data['brandInfo'] = Brand::get();

        $this->data['whyUs'] = Information::where('type', 'why-us')->get();

        $this->data['faq'] = Information::where('type', 'faq')->get();

        $this->data['recentBlog'] = Blog::with('userList')->orderBy('created', 'desc')->limit(3)->get();

        $this->data['aboutUs'] = AboutUs::first();
    }

    // Home
    public function index()
    {
        $this->data['menu']          = 'home';
        $this->data['brand_section'] = 'active';

        $this->data['sectionData'] = getSectionData()->where('page', 'home')->where('section', '!=', 'cta');
        $this->data['testimonial'] = ClientTestimonial::orderBy('created_at', 'desc')->get();

        return view('home', $this->data);
    }

    // About Us
    public function aboutUs()
    {
        $this->data['menu']          = 'about-us';
        $this->data['siteTitle']     = 'About Us';
        $this->data['breadcrumb']    = ['about-us' => 'About Us'];
        $this->data['brand_section'] = 'active';


        $this->data['info']     = aboutUs::first();
        $this->data['teamlist'] = Team::get();

        return view('about-us', $this->data);
    }

    // About Us
    public function login()
    {
        $this->data['menu']          = 'user-login';
        $this->data['siteTitle']     = 'User Login';
        $this->data['breadcrumb']    = ['user-login' => 'User Login'];
        $this->data['brand_section'] = 'inactive';

        return view('user-login', $this->data);
    }


    // Contact Us
    public function contact()
    {
        $this->data['linkInfo']      = $this->data['niche'] = null;
        $this->data['menu']          = 'contact';
        $this->data['siteTitle']     = 'Contact Us';
        $this->data['breadcrumb']    = ['contact' => 'Contact Us'];
        $this->data['brand_section'] = 'inactive';

        if (!empty($_GET['ref'])) {
            $this->data['linkInfo'] = $linkInfo = SiteList::find($_GET['ref']);
            $this->data['niche']    = Niche::whereIn('id', json_decode($linkInfo->niche))->get();
        }

        return view('contact', $this->data);
    }

    // Pricing
    public function pricing(string $url)
    {
        $this->data['menu']          = 'pricing';
        $this->data['siteTitle']     = removeDash($url);
        $this->data['breadcrumb']    = ['pricing' => 'Pricing'];
        $this->data['brand_section'] = 'active';

        $this->data['info'] = Service::with('packages')->where('page_url', $url)->first();

        return view('pricing', $this->data);
    }


    // Service
    public function singleService(string $url)
    {
        $this->data['menu']          = 'service';
        $this->data['siteTitle']     = 'Service';
        $this->data['breadcrumb']    = ['service' => 'Service'];
        $this->data['brand_section'] = 'active';

        $this->data['info'] = Service::with('packages')->where('page_url', $url)->first();

        return view('single-service', $this->data);
    }

    // Service
    public function guestPosting()
    {
        $this->data['menu']          = 'guest_posting';
        $this->data['siteTitle']     = 'Guest Posting';
        $this->data['breadcrumb']    = ['service' => 'Guest Posting'];
        $this->data['brand_section'] = 'active';

        $this->data['info'] = Service::with('packages')->where('page_url', 'guest-posting')->first();

        return view('single-service', $this->data);
    }

    // Service
    public function linkInsertion()
    {
        $this->data['menu']          = 'link_insertion';
        $this->data['siteTitle']     = 'Link Insertion';
        $this->data['breadcrumb']    = ['service' => 'Link Insertion'];
        $this->data['brand_section'] = 'active';

        $this->data['info'] = Service::with('packages')->where('page_url', 'link-insertion')->first();

        return view('single-service', $this->data);
    }

    // Blog
    public function blog()
    {
        $this->data['menu']          = 'blog';
        $this->data['siteTitle']     = 'Blog';
        $this->data['breadcrumb']    = ['blog' => 'Blog'];
        $this->data['brand_section'] = 'active';

        $this->data['info'] = Blog::with('userList')->orderBy('created', 'desc')->get();

        return view('blog', $this->data);
    }

    // Blog
    public function blogDetail($url)
    {
        $this->data['menu']          = 'blog';
        $this->data['siteTitle']     = 'Blog Details';
        $this->data['breadcrumb']    = ['blog' => 'Blog'];
        $this->data['brand_section'] = 'active';

        $this->data['info'] = Blog::with('userList')->where('page_url', $url)->first();

        return view('single-blog', $this->data);
    }

    // Contact Us Email
    public function contactEmail(Request $request)
    {
        $siteInfo = getSiteInfo();

        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name'  => ['required'],
            'email'      => ['required'],
            'phone'      => ['required'],
            'subject'    => ['required'],
            'message'    => ['required'],
        ]);

        if ($validator->fails()) {
            flash()->addWarning('Something was wrong please check and submit.', 'Warning');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $data = new ContactUs;

            $data->first_name = $request->first_name;
            $data->last_name  = $request->last_name;
            $data->email      = $request->email;
            $data->phone      = $request->phone;
            $data->subject    = $request->subject;
            $data->message    = $request->message;

            $data->save();

            Mail::to($siteInfo->email)->send(new ContactMail($data));

            flash()->addSuccess('you message send successful.', 'Success');

            return redirect('contact');
        }
    }

    public function newslatter(Request $request)
    {
        if (NewsLatter::where('email', $request->email)->exists()) {
            return response()->json(['msg' => 'Your Email Already Exists.', 'type' => 'warning']);
        } else {
            $data          = new NewsLatter;
            $data->created = date('Y-m-d');
            $data->email   = $request->email;
            $data->save();
            return response()->json(['msg' => 'You successfully Subscribed.', 'type' => 'success']);
        }
    }

    public function pages($pageUrl)
    {
        $this->data['menu']          = $pageUrl;
        $this->data['brand_section'] = 'active';
        $this->data['info']          = $info = Page::where('page_url', $pageUrl)->first();

        if (empty($info))
            abort(404);

        $this->data['breadcrumb'] = [$pageUrl => strFilter($info->title)];
        $this->data['siteTitle']  = $info->title;

        return view('info', $this->data);
    }

    public function privacyPolicy()
    {
        $this->data['menu']          = 'privacy-policy';
        $this->data['info']          = $info = Page::where('page_url', 'privacy-policy')->first();
        $this->data['brand_section'] = 'active';

        if (empty($info))
            abort(404);

        $this->data['breadcrumb'] = ['privacy-policy' => strFilter($info->title)];
        $this->data['siteTitle']  = $info->title;

        return view('single-page', $this->data);
    }

    public function termsService()
    {
        $this->data['menu']          = 'terms-of-service';
        $this->data['info']          = $info = Page::where('page_url', 'terms-of-service')->first();
        $this->data['brand_section'] = 'active';

        if (empty($info))
            abort(404);

        $this->data['breadcrumb'] = ['terms-of-service' => strFilter($info->title)];
        $this->data['siteTitle']  = $info->title;

        return view('single-page', $this->data);
    }

    public function refundPolicy()
    {
        $this->data['menu']          = 'refund-policy';
        $this->data['info']          = $info = Page::where('page_url', 'refund-policy')->first();
        $this->data['brand_section'] = 'active';

        if (empty($info))
            abort(404);

        $this->data['breadcrumb'] = ['refund-policy' => strFilter($info->title)];
        $this->data['siteTitle']  = $info->title;

        return view('single-page', $this->data);
    }

    public function dmca()
    {
        $this->data['menu']          = 'dmca';
        $this->data['info']          = $info = Page::where('page_url', 'dmca')->first();
        $this->data['brand_section'] = 'active';

        if (empty($info))
            abort(404);

        $this->data['breadcrumb'] = ['dmca' => strFilter($info->title)];
        $this->data['siteTitle']  = $info->title;

        return view('single-page', $this->data);
    }

    // Our Link Placement
    public function siteList()
    {
        $this->data['menu']          = 'siteList';
        $this->data['siteTitle']     = 'Our Site List';
        $this->data['breadcrumb']    = ['websites' => 'Websites'];
        $this->data['brand_section'] = 'active';

        $this->data['info'] = Page::where('page_url', 'websites')->first();

        $this->data['nicheList'] = Niche::all();
        $this->data['siteList']  = SiteList::with('country')->orderBy('traffic', 'desc')->get();

        return view('site-list', $this->data);
    }

    // Site details
    public function siteDetails($id)
    {
        $this->data['menu']          = 'siteList';
        $this->data['siteTitle']     = "Website Details";
        $this->data['brand_section'] = 'inactive';

        if (empty($id)) {
            return redirect('/websites');
        }

        $this->data['info'] = $info = SiteList::find($id);

        $this->data['breadcrumb'] = ['/websites/' . $info->id . '/details' => $info->title];


        return view('site-details', $this->data);
    }

    // Our Checkout Order Invoice
    public function orderInvoice($oid)
    {
        $this->data['menu']          = 'invoice';
        $this->data['siteTitle']     = 'View Invoice';
        $this->data['brand_section'] = 'inactive';

        $this->data['orderInfo'] = Order::with('admin', 'orderItem', 'emailFrom')->where('order_no', $oid)->first();

        return view('download.order-invoice', $this->data);
    }

    // Our Order Invoice Downloader
    public function download($oid)
    {
        $this->data['menu'] = 'download';

        $siteInfo = getSiteInfo();

        $this->data['orderInfo'] = $info = Order::with('admin', 'orderItem', 'emailFrom')->where('order_no', $oid)->first();

        $name = date('dmY') . rand(1001, 9999) . '#' . $info->order_no;

        $html = view('download.download-order', $this->data);

        $mpdf = new PDF([
            'margin_left'   => 0,
            'margin_right'  => 0,
            'margin_top'    => 27,
            'margin_bottom' => 48,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        $mpdf->SetTitle($siteInfo->site_name . " - Invoice No #" . $info->order_id);
        $mpdf->SetAuthor("Parvez IT");
        $mpdf->SetProtection(array('print'));

        // $mpdf->SetWatermarkImage(asset('public/images/devzet.png'),0.04,35,'F');
        // $mpdf->watermarkImageAlpha = 0.04;
        // $mpdf->showWatermarkImage = true;

        // $mpdf->SetWatermarkText(strFilter($info->order->status));
        $mpdf->SetWatermarkText(strtoupper($siteInfo->site_name));
        $mpdf->watermarkTextAlpha = 0.05;
        $mpdf->showWatermarkText  = true;
        $mpdf->watermark_font     = 'DejaVuSansCondensed';

        $mpdf->SetDisplayMode('fullpage');

        $mpdf->defaultheaderline = 0;
        $mpdf->defaultfooterline = 0;

        $mpdf->SetHeader('
        <div class="header main_padding">
            <div class="logo">' . $siteInfo->site_name . '</div>
            <div class="title">
                Invoice
            </div>
        </div>
        ');

        $mpdf->SetFooter('
            <div class="order_footer main_padding">
                <div class="sign_underline"></div>
                <div class="contain">
                    <p><span class="weight_600">' . $info->admin->name . '</span></p>
                    <p>' . $siteInfo->site_name . '</p>
                    <p><span class="weight_600">Email :</span> ' . $info->emailFrom->email . '</p>
                </div>
            </div>

            <div class="footer">
                <p>' . $siteInfo->location . '</p>
            </div>
        ');

        $mpdf->WriteHTML($html);

        $mpdf->Output($name . ".pdf", 'I');
    }

    // Our Checkout Invoice
    public function invoiceView($refCode)
    {
        $this->data['menu']          = 'invoice';
        $this->data['siteTitle']     = 'View Invoice';
        $this->data['brand_section'] = 'inactive';

        $this->data['invoiceInfo'] = $invoiceInfo = Invoice::with('customer', 'method', 'admin')->where('ref_code', $refCode)->first();

        $this->data['orderList'] = Order::with('admin', 'orderItem', 'emailFrom', 'billType')->whereIn('id', json_decode($invoiceInfo->order_id))->get();

        $this->data['countryList'] = Country::get();

        return view('download.invoice', $this->data);
    }

    // Our Invoice Downloader
    public function downloadInvoice($refCode)
    {
        $this->data['menu'] = 'download';

        $siteInfo = getSiteInfo();

        $this->data['invoiceInfo'] = $invoiceInfo = Invoice::with('customer', 'method', 'admin')->where('ref_code', $refCode)->first();

        $this->data['orderList'] = Order::with('admin', 'orderItem', 'emailFrom')->whereIn('id', json_decode($invoiceInfo->order_id))->get();

        if (empty($this->data['invoiceInfo'])) {
            flash()->addError('Invoice not found! Please contact our support team.');
            return redirect()->route('home');
        }

        $name = date('dmY') . rand(1001, 9999) . '#' . $invoiceInfo->invoice_no;

        $html = view('download.download-invoice', $this->data);

        $mpdf = new PDF([
            'margin_left'   => 0,
            'margin_right'  => 0,
            'margin_top'    => 23,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        $mpdf->SetTitle($siteInfo->site_name . " - Invoice No #" . $invoiceInfo->invoice_no);
        $mpdf->SetAuthor("Parvez IT");
        $mpdf->SetProtection(array('print'));

        if (!empty($siteInfo->favicon)) {
            $mpdf->SetWatermarkImage(asset($siteInfo->favicon), 0.04, 35, 'F');
            $mpdf->watermarkImageAlpha = 0.04;
            $mpdf->showWatermarkImage  = true;
        } else {
            // $mpdf->SetWatermarkText(strFilter($info->order->status));
            $mpdf->SetWatermarkText(strtoupper($siteInfo->site_name));
            $mpdf->watermarkTextAlpha = 0.05;
            $mpdf->showWatermarkText  = true;
            $mpdf->watermark_font     = 'DejaVuSansCondensed';
        }

        $mpdf->SetDisplayMode('fullpage');
        $mpdf->defaultheaderline = 0;
        $mpdf->defaultfooterline = 0;

        $mpdf->SetHeader('
        <div class="header main_padding">
            <div class="logo">
                <img src="' . asset($siteInfo->logo) . '" alt="Logo">
            </div>
            <div class="title">
                Invoice
            </div>
        </div>
        ');

        // $mpdf->SetFooter('
        //     <div class="order_footer main_padding">
        //         <div class="sign_underline"></div>
        //         <div class="contain">
        //             <p><span class="weight_600">'. $invoiceInfo->admin->name .'</span></p>
        //             <p>'. $siteInfo->site_name . '</p>
        //             <p><span class="weight_600">Email :</span> '. $orderList[0]->emailFrom->email .'</p>
        //         </div>
        //     </div>
        //     <div class="footer">
        //         <p>'. $siteInfo->location .'</p>
        //     </div>
        // ');

        $mpdf->WriteHTML($html);
        $mpdf->Output($name . ".pdf", 'I');
    }

    public function activities(string $id = null)
    {
        $data = Order::find($id);

        $data->is_payment = 1;

        $data->save();

        flash()->addSuccess('Order Payment successful.', 'warnning');

        return redirect()->back();
    }
}
