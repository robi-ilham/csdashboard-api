<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaiUser extends Model
{
    use HasFactory;

    protected $connection = 'wai';
    protected $table = 'users';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $with=['division','client','group','sender'];

    protected $guarded=[];
    public function division(){
        return $this->hasOne(JnsBroadcastDivision::class,'id','division_id');
    }
    public function group(){
        return $this->hasOne(JnsWebGroup::class,'id','group_id');
    }
    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
    public function sender(){
        return $this->hasOne(Sender::class,'sender_id','sender_id');
    }
}
