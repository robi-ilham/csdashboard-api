<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsBlackList extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'blacklist_numbers';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $guarded=[];
}
