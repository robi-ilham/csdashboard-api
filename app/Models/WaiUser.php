<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaiUser extends Model
{
    use HasFactory;

    protected $connection = 'wai';
    protected $table = 'users';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $guarded=[];
}
