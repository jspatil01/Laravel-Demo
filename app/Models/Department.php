<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $fillable = [
        'dept_name'
    ];

    public function teachers(){
        return $this->belongsToMany(Teacher::class, 'teacher_departments', 'dept_id', 'teacher_id')->withTimestamps();
    }
}