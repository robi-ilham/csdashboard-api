<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PctClient extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'JTS_CLI_Client';

    protected $with=['config','detail'];

    public function config(){
        return $this->hasOne(PctClientConfig::class,'iClientId','iId');
    }
    public function detail(){
        return $this->hasOne(PctClientDetail::class,'iClientId','iId');
    }
}
