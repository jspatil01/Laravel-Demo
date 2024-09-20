<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'DOB',
        'gender',
        'department',
        'manager_id'
    ];

    //One-to-One
    public function contact(){
        return $this->hasOne(Contact::class, 'emp_id');
    }

    //one-to-many
    public function manyContacts(){
        return $this->hasMany(Contact::class, 'emp_id');
    }

    //Has one of many
    public function latestContact(){
        return $this->hasOne(Contact::class, 'emp_id')->latestOfMany();
    }

    public function currentContacts(){
        return $this->hasOne(Contact::class, 'emp_id')->ofMany([
            'created_at'=>'max',
            'id'=>'max'
        ], function(Builder $query){
            $query->where('created_at', '<', now());
        });
    }

    //Convert many - to - one relationship
    public function sampleContact(){
        return $this->manyContacts()->one();
    }


}