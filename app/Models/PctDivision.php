<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PctDivision extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'JTS_CLI_ClientDivision';

    protected $guarded=[]
}
