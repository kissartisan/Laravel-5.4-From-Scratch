<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

use App\Tag;
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
	 * Relationship: A post belongs to a user
	 */
	public function user()
    {
    	return $this->belongsTo(User::class);
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


	public static function archives()
	{
		return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
                    ->groupBy('year', 'month')
                    ->orderByRaw('min(created_at) desc')
                    ->get()
                    ->toArray();
	}

    public function tags()
    {
        // Any post may have many tags
        // Any tag may have many post
        return $this->belongsToMany(Tag::class);
    }
}
