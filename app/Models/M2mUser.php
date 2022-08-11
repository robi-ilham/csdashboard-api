<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M2mUser extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'client_accesses';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $with = ['client','division'];

    protected $guarded=[];

    public function division(){
        return $this->hasOne(JnsBroadcastDivision::class,'id','division_id');
    }
    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
}
