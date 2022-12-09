<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $guarded = [];

    public function get_categories()
    {
        return $this->belongsTo(Category::class,'cat_id','id');
    }

    public function get_tags()
    {
        return $this->belongsToMany(Tag::class,'post_tags','post_id','tag_id');
    }

}
