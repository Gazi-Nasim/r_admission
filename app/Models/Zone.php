<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function zoneChoices()
    {
        return $this->hasMany(ZoneChoice::class, 'zone_id', 'id');
    }
}
