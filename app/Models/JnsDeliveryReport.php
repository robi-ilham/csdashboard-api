<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsDeliveryReport extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'dr_push_accesses';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];
}
