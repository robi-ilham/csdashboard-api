<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsTokenBalance extends Model
{
    use HasFactory;

    protected $connection = 'jnstoken';
    protected $table = 'accounts';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];
}
