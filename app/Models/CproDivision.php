<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CproDivision extends Model
{
    use HasFactory;
    protected $connection = 'cpro';
    protected $table = 'divisions';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable=['name','client_id'];

    protected $with = ['client'];

    public function client(){
        return $this->hasOne(JnsBroadcastClient::class,'id','client_id');
    }
}
