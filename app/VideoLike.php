<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoLike extends Model {
	public $table = 'videos_like';
	protected $fillable = [
		'video_id',
		'user_id',
	];
}
