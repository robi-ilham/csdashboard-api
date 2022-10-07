<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsTokenMap extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'token_maps';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];
    protected $with=['client','division','mask','otp','nonotp'];

    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
    public function division(){
        return $this->hasOne(JnsBroadcastDivision::class,'id','division_id');
    }
    public function mask(){
        return $this->hasOne(BroadcastMasks::class,'id','mask_id');
    }
    public function otp(){
        return $this->hasMany(TokenMapGroup::class,'token_map_id','id')->where('token_map_groups.service_type','OTP');
    }
    public function nonotp(){
        return $this->hasMany(TokenMapGroup::class,'token_map_id','id')->where('token_map_groups.service_type','NON OTP');
    }
}
