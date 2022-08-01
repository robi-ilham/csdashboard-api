<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsBroadcastDivision extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'divisions';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable=['name','client_id'];

    protected $with = ['client'];

    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
}
