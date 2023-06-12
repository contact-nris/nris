<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscribeNewsletter extends Model {
	public $table = 'subscribe_newsletters';
	protected $casts = [];
	protected $appends = [];
}

?>