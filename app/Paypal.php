<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paypal extends Model {
	public $table = 'paypal_payments';
	public $fillable = ['txn_id'];
	protected $casts = [
		'response' => 'array',
	];
}
