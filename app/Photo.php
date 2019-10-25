<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $fillable = ['name','path','size'];

    
    public function post()
    {
        return $this->hasOne(Post::class);
    }
    
}
