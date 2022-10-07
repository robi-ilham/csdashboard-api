<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsPrivilege extends Model
{
    use HasFactory;
    
    protected $connection = 'jnsbroadcast';
    protected $table = 'client_privileges';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';

    protected $with=['client','division','type'];
    

    protected $guarded=[];

    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
    public function division(){
        return $this->hasOne(JnsBroadcastDivision::class,'id','division_id');
    }
    public function type(){
        return $this->hasOne(BroadcastPrivilegeType::class,'id','privilege_type_id');
    }
}
