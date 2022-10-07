<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastMaskClient extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'mask_clients';
    
    protected $with=['client'];
    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
}
