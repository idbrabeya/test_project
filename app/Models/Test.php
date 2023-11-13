<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'email',
        'phone',
        'status',
        'images',
        'marital_status'
    ];
    public function imagess()
    {
        return $this->hasMany(Image::class); 
    }
}
