<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_no',
        'email',
        'city',
        'emp_id',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
