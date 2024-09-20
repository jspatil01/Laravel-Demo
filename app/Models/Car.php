<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Car extends Model
{
    use HasFactory;

    // protected $table = 'my_car';
    protected $fillable =[
        'user_id',
        'car_name',
        'model',
        'price',
        'registration_date',
        'attachment'
    ];

    protected $casts = [
        'price' => 'double',
        'registration_date' => 'datetime:d-M-Y',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function getPriceAttribute($value){
        return "$". number_format($value, 2);
    }

    public function carName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper($value),
        );
    }
}