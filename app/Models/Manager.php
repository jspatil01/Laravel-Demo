<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
    ];

    public function employee(){
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function employeeDetail()
    {
        return $this->hasManyThrough(
            Contact::class, 
            Employee::class,
            'manager_id',         // Foreign key on the employees table
            'emp_id',             // Foreign key on the contacts table
            'id',                 // Local key on the managers table
            'id'                  // Local key on the employees table
        );
    }
}