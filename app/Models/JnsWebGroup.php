<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsWebGroup extends Model
{
    use HasFactory;
    protected $connection = 'jnsweb';
    protected $table = 'groups';

    
}
