<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NrisLIke extends Model {
	public $table = 'nris_like';
	protected $fillable = [
		'talk_id',
		'user_id',
	];
}
