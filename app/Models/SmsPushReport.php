<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsPushReport extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'report_requests';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $guarded=[];


}
