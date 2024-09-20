<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $fillable = [
        'content',
    ]; 

    protected $touches = ['post'];
    public function commentable(){
        return $this->morphTo();
    }
}
