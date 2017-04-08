<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

// Extend the Post with our own Model
class Post extends Model
{
	public function comments() {
		return $this->hasMany(Comment::class);
	}

	public function addComment($body)
	{
		// This will automatically matches the post id of a newly created comment
		$this->comments()->create(compact('body'));

		/*Comment::create([
    		'body' => $body,
    		'post_id' => $this->id // instance of Post Model
    	]);*/
	}

	public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
