<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable =[
        "name",
        "email",
        "gender",
        "contactNo",
    ];

    // public function departments(){
    //     return $this->belongsToMany(Department::class, 'stu__depts', 'stu_id', 'dept_id');
    // }
}
