<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;
    protected $guarded = array('id');

    public static $rules = array(
        'name' => 'required',
        'content' => 'required'
    );

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
