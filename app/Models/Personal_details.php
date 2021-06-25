<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal_details extends Model
{
    use HasFactory;
    protected $table='personal_details';
    protected $fillable = [
        'address',
        'district',
        'pin_code',
        'place',
        'state'
    ];

}//end class
