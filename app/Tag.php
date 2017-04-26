<?php

namespace App;

use App\Post;

class Tag extends Model
{
    public function posts()
    {
        // Any post may have many tags
        // Any tag may have many post
        return $this->belongsToMany(Post::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
