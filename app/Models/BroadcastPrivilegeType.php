<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastPrivilegeType extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'privilege_types';
}
