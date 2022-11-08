<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenMapGroup extends Model
{
    use HasFactory;

    protected $connection = 'jnsbroadcast';
    protected $table = 'token_map_groups';

    // protected $with=['tokenmap'];
    // public function tokenmap(){
    //     return $this->hasOne(JnsTokenMap::class,'id','token_map_id');
    // }
}
