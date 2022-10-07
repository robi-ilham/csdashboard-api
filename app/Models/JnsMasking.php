<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsMasking extends Model
{
    use HasFactory;
    protected $connection = 'jnsbroadcast';
    protected $table = 'masks';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];

    protected $with= ['clients'];
    
    public function clients(){
        return $this->hasMany(BroadcastMaskClient::class,'mask_id','id');
    }
}
