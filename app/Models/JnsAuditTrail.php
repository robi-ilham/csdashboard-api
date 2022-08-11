<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsAuditTrail extends Model
{
    use HasFactory;

    protected $connection = 'jnsweb';
    protected $table = 'audits';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $guarded=[];
}

