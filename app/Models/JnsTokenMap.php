<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsTokenMap extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'token_maps';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];
}
