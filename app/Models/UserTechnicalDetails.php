<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTechnicalDetails extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id','available_format','content','skills','subjects'

    ];

    //Defined Realtion between UserTechnicalDetails And User
    public function fn_user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
