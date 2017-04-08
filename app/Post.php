<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon; 

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

	/**
	 * Query scope for filter function
	 */
	public function scopeFilter($query, $filters)
	{
		if ($month = $filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }

        if ($year = $filters['year']) {
            $query->whereYear('created_at', $year);
        }
	}

	/**
	 * Relationship: A post belongs to a user
	 */
	public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
