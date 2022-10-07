<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastDrpushCategory extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'drpush_categories';

}
