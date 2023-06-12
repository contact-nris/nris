<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogLike extends Model {
	public $table = 'blogs_like';
	protected $fillable = [
		'blog_id',
		'user_id',
	];
}
