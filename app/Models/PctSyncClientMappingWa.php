<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PctSyncClientMappingWa extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'JTS_SYNC_MappingClientWA';
    
    public $timestamps = false;


    protected $guarded=[];
}
