<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsQueue extends Model
{
    protected $guarded = ['id'];
    protected $table   = 'sms_queue';
}
