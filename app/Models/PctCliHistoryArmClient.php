<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PctCliHistoryArmClient extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'JTS_CLI_HistoryARMClient';

    const CREATED_AT = 'dtmDateInserted';
    const UPDATED_AT = 'dtmDateUpdated';

    protected $guarded=[];
}
