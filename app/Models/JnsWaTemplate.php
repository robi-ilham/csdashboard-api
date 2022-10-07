<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsWaTemplate extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'whatsapp_template_messages';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];
    protected $with=['client','mask'];

    public function  client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
    public function  mask(){
        return $this->hasOne(BroadcastMasks::class,'id','mask_id');
    }
}
