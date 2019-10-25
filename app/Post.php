<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['title','slug_title','photo_id','content','category_id','sub_title','status'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function posttags()
    {
        return $this->hasMany(PostTags::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_id');
    }
}
