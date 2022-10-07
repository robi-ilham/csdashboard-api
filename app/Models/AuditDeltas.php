<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditDeltas extends Model
{
    use HasFactory;
    protected $connection = 'jnsweb';
    protected $table = 'audit_deltas';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

}
