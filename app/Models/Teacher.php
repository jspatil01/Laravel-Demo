<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "email",
        "gender",
        "contact_no"
    ];

    public function departments(){
        return $this->belongsToMany(Department::class, 'teacher_departments',    'teacher_id', 'dept_id')->withTimestamps();
    }
}
