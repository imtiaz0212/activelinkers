<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCamapignItems extends Model
{
    use HasFactory;

    public function campaign()
    {
        return $this->belongsTo(EmailCampaign::class, 'email_campaign_id')->select('id', 'email_from', 'subject', 'template');
    }
}
