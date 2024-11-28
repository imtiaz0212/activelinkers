<p><img style="width: 15%;" src="{{asset($siteInfo->logo)}}" alt="Logo"></p>
<br>
<p>
    <?php
    $templateInfo = \App\Models\EmailTemplate::where('id', 9)->first();
    $template = !empty($templateInfo) ? $templateInfo->description : '';

    $invoiceLink = '<p>' . url('invoice', $invoiceInfo->ref_code) . '</p> <br>';
    $invoiceLink .= '<a href="' . url('invoice', $invoiceInfo->ref_code) . '" style="background-color: #bcec00; padding: 14px 30px; border-radius: 4px; color: #0F1626; text-decoration: none"> Show Invoice </a>';


    $paymentDetails = 'Payment Method:  Stripe <br>';
    $paymentDetails .= 'Payment Date: '. $invoiceInfo->payment_date .' <br>';
    $paymentDetails .= 'Paid Amount: $'. $invoiceInfo->grand_total .' <br>';

    $template = str_replace('[Client Name]', $invoiceInfo->customer ?->full_name, $template);
    $template = str_replace('[Invoice No]', $invoiceInfo->invoice_no, $template);
    $template = str_replace('[Invoice Date]', $invoiceInfo->created, $template);
    $template = str_replace('[Order Date]', $orderInfo[0]->created, $template);
    $template = str_replace('[Total Bill]', $invoiceInfo->grand_total, $template);
    $template = str_replace('[Invoice Link]', $invoiceLink, $template);
    $template = str_replace('[Payment Details]', $paymentDetails, $template);
    ?>

    {!! $template !!}
</p>

<p>Feel free to reach out if you have any questions or concerns.</p>
<br>

<p>
    Best regards,<br>
    <b>{{$siteInfo->site_name}}</b><br>
    Skype: <a href="skype:{{$siteInfo->skype}}?chat" target="_blank">{{$siteInfo->skype}}</a><br>
    Mobile: {{$siteInfo->mobile}}<br>
    Office Address: {{$siteInfo->us_location}}
</p>

<p>
    @if (!empty($siteInfo->facebook))
        <a style="display: inline-block; vertical-align:middle" href="{{$siteInfo->facebook}}">
            <img style="width: 45px;" src="{{asset('uploads/social-icon/facebook.png')}}"></a>&nbsp;
    @endif

    @if (!empty($siteInfo->google_plus))
        <a style="display: inline-block; vertical-align:middle" href="{{$siteInfo->google_plus}}">
            <img style="width: 45px;" src="{{asset('uploads/social-icon/google.png')}}"></a>&nbsp;
    @endif

    @if (!empty($siteInfo->linkedin))
        <a style="display: inline-block; vertical-align:middle" href="{{$siteInfo->linkedin}}">
            <img style="width: 45px;" src="{{asset('uploads/social-icon/linkedin.png')}}"></a>&nbsp;
    @endif

    @if (!empty($siteInfo->twitter))
        <a style="display: inline-block; vertical-align:middle" href="{{$siteInfo->twitter}}">
            <img style="width: 45px;" src="{{asset('uploads/social-icon/twitter.png')}}"></a>&nbsp;
    @endif

    @if (!empty($siteInfo->youtube))
        <a style="display: inline-block; vertical-align:middle" href="{{$siteInfo->youtube}}">
            <img style="width: 45px;" src="{{asset('uploads/social-icon/youtube.png')}}"></a>&nbsp;
    @endif

    <a style="background-color: #4e48e0; padding: 10px 16px; border-radius: 4px; color: #ffffff; display: inline-block; vertical-align:middle; text-decoration: none"
       href="{{url('/contact')}}" target="_blank">Contact Us</a>
</p>

