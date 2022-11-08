<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PctClientDivision extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'JTS_CLI_ClientDivision';

    const CREATED_AT = 'dtmDateInserted';
    const UPDATED_AT = 'dtmDateUpdated';

    protected $guarded=[];

    protected $with=['client'];

    public function client(){
        return $this->hasOne(PctClient::class,'iId','iClientId');
    }
}
