<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsBroadcastClient extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'clients';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
}
