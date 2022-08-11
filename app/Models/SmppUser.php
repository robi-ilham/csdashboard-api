<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmppUser extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'clientsmppsetting';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    
    protected $with = ['client'];

    protected $guarded=[];

    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
}

