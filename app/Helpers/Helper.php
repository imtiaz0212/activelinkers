<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

function formatNumber($number)
{
    if ($number >= 1000000) {
        return round($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return round($number / 1000, 1) . 'K+';
    } else {
        return $number;
    }
}

function getLastTwelveMonthNames($date)
{
    Carbon::setlocale(config('app.locale'));

    $month_names = [
        ucfirst((new Carbon($date))->translatedFormat('F'))
    ];

    for ($i = 1; $i <= 11; $i++) {
        $month_names[$i] = ucfirst((new Carbon($date))->subMonth()->translatedFormat('F'));
        $date            = (new Carbon($date))->subMonth();
    }

    return $month_names;
}

function getMonthnumber($name)
{
    $monthNumber = '';

    $montharray = [
        '01' => "january",
        '02' => "february",
        '03' => "march",
        '04' => "april",
        '05' => "may",
        '06' => "june",
        '07' => "july",
        '08' => "august",
        '09' => "september",
        '10' => "october",
        '11' => "november",
        '12' => "december"
    ];

    foreach ($montharray as $key => $month) {
        if ($month == $name) {
            $monthNumber = $key;
        }
    }

    return $monthNumber;
}

function canAccess(array $permissions)
{
    $permission = auth()->guard('admin')->user()->hasAnyPermission($permissions);
    $superAdmin = auth()->guard('admin')->user()->hasRole('Super Admin');

    if ($permission || $superAdmin) {
        return true;
    } else {
        return false;
    }
}

function getSectionData()
{
    return Cache::rememberForever("sectionData", function () {
        return DB::table('sections')->select('page', 'section', 'content')->get();
    });
}

function getSiteInfo()
{
    return Cache::rememberForever("siteInfo", function () {
        $data = [
            'site_name'        => '',
            'login_bg'         => '',
            'logo'             => '',
            'footer_logo'      => '',
            'favicon'          => '',
            'copyright'        => '',
            'map_title'        => '',
            'map'              => '',
            'google_plus'      => '',
            'facebook'         => '',
            'twitter'          => '',
            'instagram'        => '',
            'linkedin'         => '',
            'youtube'          => '',
            'mobile'           => '',
            'skype'            => '',
            'whatsapp'         => '',
            'telephone'        => '',
            'fax'              => '',
            'email'            => '',
            'location'         => '',
            'us_location'      => '',
            'about_us'         => '',
            'meta_title'       => '',
            'meta_tag'         => '',
            'meta_description' => '',
            'meta_image'       => '',
        ];

        $siteInfo = DB::table('settings')->get();
        if (!empty($siteInfo)) {
            foreach ($siteInfo as $row) {
                $data[$row->meta_key] = $row->meta_value;
            }
        }

        return (object)$data;
    });
}

function dateFormat($date = null, $formate = 'd-m-Y')
{
    if (!empty($date)) return date($formate, strtotime($date));
}

function getRandomStr($length = 10)
{
    $characters       = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return strtolower($randomString);
}

function strFilter($text = '')
{
    if (!empty($text)) {
        $text = trim($text);

        if (mb_detect_encoding($text) == 'UTF-8') {
            $text = str_replace('_', ' ', $text);
        } else {
            $text = ucwords(str_replace('_', ' ', $text));
        }

        return $text;
    }

    return 'N/A';
}

function strClean($text = '')
{
    if (!empty($text)) {
        $text = trim($text);

        if (mb_detect_encoding($text) == 'UTF-8') {
            $text = str_replace(' ', '', $text);
        } else {
            $text = ucwords(str_replace(' ', '', $text));
        }

        return preg_replace('/[^A-Za-z0-9\-]/', '', $text);
    }
}

function strSlug($text = '')
{
    if (!empty($text)) {
        $text = trim($text);

        if (mb_detect_encoding($text) == 'UTF-8') {
            $text = str_replace(' ', '-', $text);
        } else {
            $text = trim(preg_replace('/[^A-Za-z ]/', '', $text));
            $text = str_replace(' ', '-', strtolower($text));
        }

        //$randomNumber = substr(str_shuffle('0123456789'), 0, 10);
        //$text .= '-' . $randomNumber;

        return $text;
    }
}

function removeDash($text = '')
{
    if (!empty($text)) {
        $text = trim($text);

        if (mb_detect_encoding($text) == 'UTF-8') {
            $text = str_replace('-', ' ', $text);
        } else {
            $text = str_replace('-', ' ', ucwords($text));
        }

        return $text;
    }
}

function strLimit($text, $count, $prefix = "")
{
    $text   = str_replace("  ", " ", strip_tags($text));
    $string = explode(" ", $text);
    $trimed = "";
    $count  = ((count($string) - 1) > $count) ? ($count - 1) : (count($string) - 1);

    for ($wordCounter = 0; $wordCounter <= $count; $wordCounter++) {
        $trimed .= $string[$wordCounter];
        if ($wordCounter < $count) {
            $trimed .= " ";
        }
    }

    if ((count($string) - 1) >= $count) {
        $trimed .= $prefix;
    }

    $trimed = trim($trimed);
    return $trimed;
}

function uploadFile($file = '', $path = '')
{
    if (!empty($file) && !empty($path)) {

        $fileInfo = $file->getClientOriginalName();

        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);

        $filename = date('ymd') . rand(1000, 9999) . rand(100, 999) . '.' . $extension;

        if (!is_dir($path)) mkdir($path, 0700, true);

        $file->move($path, $filename);

        return $path . '/' . $filename;
    }

    return false;
}

function uploadImage($sourcePath = '', $uploadPath = '', $maxWidth = 0, $maxHeight = 0, $quality = 100)
{
    if (!empty($sourcePath) && !empty($uploadPath)) {

        if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);

        $mimeType = $sourcePath->getMimeType();
        list($imgWidth, $imgHeight) = getimagesize($sourcePath);

        $fileName = date('ymd') . rand(100000, 999999) . '.webp';

        if ($mimeType == 'image/jpeg') {
            $sourceImage = imagecreatefromjpeg($sourcePath);
        } elseif ($mimeType == 'image/png') {
            $sourceImage = imagecreatefrompng($sourcePath);
        } elseif ($mimeType == 'image/webp') {
            $sourceImage = imagecreatefromwebp($sourcePath);
        } elseif ($mimeType == 'image/gif') {
            $sourceImage = imagecreatefromgif($sourcePath);
        } else {
            return false;
        }

        imagepalettetotruecolor($sourceImage);

        if (!empty($maxWidth) && !empty($maxHeight)) {

            if ($imgWidth > $imgHeight) {
                if ($imgWidth > $maxWidth) {
                    $newWidth  = $maxWidth;
                    $newHeight = ($imgHeight / $imgWidth) * $maxWidth;
                } else {
                    $newWidth  = $imgWidth;
                    $newHeight = $imgHeight;
                }
            } else {
                if ($imgHeight > $maxHeight) {
                    $newHeight = $maxHeight;
                    $newWidth  = ($imgWidth / $imgHeight) * $maxHeight;
                } else {
                    $newWidth  = $imgWidth;
                    $newHeight = $imgHeight;
                }
            }

            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $imgWidth, $imgHeight);
            $sourceImage = $newImage;

            $newImage = imagecreatetruecolor($maxWidth, $maxHeight);

            $x = ($newWidth - $maxWidth) / 2;
            $y = ($newHeight - $maxHeight) / 2;

            imagecopyresampled($newImage, $sourceImage, 0, 0, $x, $y, $maxWidth, $maxHeight, $maxWidth, $maxHeight);
            $sourceImage = $newImage;
        }

        $uploadPath = $uploadPath . '/' . $fileName;

        // Convert the image to WebP format
        if ($sourceImage !== false && imagewebp($sourceImage, $uploadPath, $quality)) {
            imagedestroy($sourceImage);
            return $uploadPath;
        }
    }

    return false;
}

function readingTime($title = null, $subtitle = null, $short_description = null, $description = null)
{

    $allText        = "";
    $wordsPerMinute = 200; // Average case.

    $title             = (!empty($title) ? strip_tags($title) : "");
    $subtitle          = (!empty($subtitle) ? strip_tags($subtitle) : "");
    $short_description = (!empty($short_description) ? strip_tags($short_description) : "");
    $description       = (!empty($description) ? strip_tags($description) : "");

    $allText = ($title . $subtitle . $short_description . $description);

    $words       = explode(' ', $allText);
    $readingTime = count($words) / $wordsPerMinute;
    return ceil($readingTime);
}

function bn_number($number)
{
    $bn_numbers = ["১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০"];
    $en_numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
    return str_replace($en_numbers, $bn_numbers, $number);
}

function en_number($number)
{
    $bn_numbers = ["১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০"];
    $en_numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
    return str_replace($bn_numbers, $en_numbers, $number);
}

function bn_date($date)
{
    // Numbers
    $bn_numbers = ["১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০"];
    $en_numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];

    // Months
    $en_months       = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $en_short_months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $bn_months       = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];

    // Days
    $en_days       = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    $en_short_days = ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
    $bn_short_days = ['শনি', 'রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহঃ', 'শুক্র'];
    $bn_days       = ['শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার'];

    // Convert Numbers
    $date = str_replace($en_numbers, $bn_numbers, $date);

    // Convert Months
    $date = str_replace($en_months, $bn_months, $date);
    $date = str_replace($en_short_months, $bn_months, $date);

    // Convert Days
    $date = str_replace($en_days, $bn_days, $date);
    $date = str_replace($en_short_days, $bn_short_days, $date);
    $date = str_replace($en_days, $bn_days, $date);
    return $date;
}

function removeHttp($url)
{
    $mainUrl = parse_url($url);
    if (!empty($mainUrl['host'])) {
        $viewUrl = str_replace('www.', '', $mainUrl['host']);
        return $viewUrl;
    }
}

/* rank website */
function rankWebsite()
{
    $rankWebsite = app('App\Helpers\RankWebsite');
    return new $rankWebsite;
}

/* send mail */
function sendMail()
{
    $sendPulse = app('App\Helpers\SendPulse');
    return new $sendPulse;
}
