<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsDeliveryReport extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'dr_push_accesses';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];

    protected $with=['client','division','mask','category'];

    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
    public function division(){
        return $this->
        hasOne(JnsBroadcastDivision::class,'id','division_id');
    }
    public function mask(){
        return $this->hasOne(BroadcastMasks::class,'id','mask_id');
    }
    public function category(){
        return $this->hasOne(BroadcastDrpushCategory::class,'id','drpush_category_id');
    }
   
}
