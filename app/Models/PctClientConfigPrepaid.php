<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PctClientConfigPrepaid extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'JTS_CLI_ClientConfigPrepaidDivision';

    protected $guarded=[];
}
