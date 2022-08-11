<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsInvalidWording extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'regex_invalid_wordings';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $guarded=[];
}
