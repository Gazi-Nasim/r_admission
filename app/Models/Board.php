<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $guarded    = ['id'];
    public    $timestamps = false;

    use HasFactory;
}
