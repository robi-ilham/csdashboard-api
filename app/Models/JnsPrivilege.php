<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsPrivilege extends Model
{
    use HasFactory;
    
    protected $connection = 'jnsbroadcast';
    protected $table = 'client_privileges';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];
}
