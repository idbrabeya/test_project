<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable =[
        'test_id',
        'images'
    ];
    public function testre(){
        return $this->belongsTo(Test::class,'test_id','id');
    }
   
}
