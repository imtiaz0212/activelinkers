<p><img style="width: 15%;" src="{{asset($siteInfo->logo)}}" alt="Logo"></p>
<br>

<p>
    {!! $data->message !!}
</p>
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