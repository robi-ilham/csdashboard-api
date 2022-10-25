<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebHook extends Model
{
    use HasFactory;

    protected $connection = 'common';
    protected $table = 'interactiveshortcode';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';


    protected $guarded=[];
   
   
}
