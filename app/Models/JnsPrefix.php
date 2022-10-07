<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsPrefix extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'prefix_regexes';

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_modified';
    

    protected $guarded=[];

    protected $with=['provider'];

    public function provider(){
        return $this->hasOne(JnsProvider::class,'id','provider_id');
    }
}
