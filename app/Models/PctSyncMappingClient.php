<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PctSyncMappingClient extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'JTS_SYNC_MappingClient';
    public $timestamps = false;



    protected $guarded=[];
}
