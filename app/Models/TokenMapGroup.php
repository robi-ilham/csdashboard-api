<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenMapGroup extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'token_map_groups';
}
