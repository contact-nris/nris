<?php

namespace App;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable {
	use Notifiable;
	protected $guard = 'admin';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public static function count_c($filter = array()) {
		$query = self::selectRaw('count(id) as total');

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(created_at) >= "' . $filter['date_from'] . '" AND DATE(created_at) <= "' . $filter['date_to'] . '"');
		}

		return $query->first()->total;
	}

	public function sendPasswordResetNotification($token) {
		$this->notify(new AdminResetPasswordNotification($token));
	}
}
