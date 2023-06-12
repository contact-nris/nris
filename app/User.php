<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

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

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function getNameAttribute() {
		return $this->first_name . ' ' . $this->last_name;
	}

	public function cityname() {
		return $this->hasOne('App\City', 'id', 'city');
	}

	public function getImageUrlAttribute() {
		if (!empty($this->profile_photo) && file_exists(public_path('upload/users/') . $this->profile_photo)) {
			//  return assets_url('https://namasteflavours.ca/upload/users/' . $this->profile_photo);
			return assets_url('https://nris.com/upload/users/' . $this->profile_photo);

		} else {
			$colors = array(
				'a' => '00bfa5',
				'b' => '6200ea',
				'c' => 'ffd600',
				'd' => '64dd17',
				'e' => 'aa00ff',
				'f' => 'c51162',
				'g' => '2962ff',
				'h' => '00c853',
				'i' => 'ffab00',
				'j' => '0091ea',
				'k' => 'ffffff',
				'l' => '304ffe',
				'm' => 'd50000',
				'n' => 'aeea00',
				'o' => '263238',
				'p' => 'dd2c00',
				'q' => '212121',
				'r' => '00b8d4',
				's' => '00b8d4',
				't' => '00bfa5',
				'u' => '6200ea',
				'v' => 'ffd600',
				'w' => '64dd17',
				'x' => 'aa00ff',
				'y' => 'c51162',
				'z' => '2962ff',
			);

			$alpha = strtolower($this->first_name[0]);
			return 'https://eu.ui-avatars.com/api/?background=' . (isset($colors[$alpha]) ? $colors[$alpha] : '') . '&color=fff&bold=true&&name=' . $this->first_name . '+' . $this->last_name;
		}
	}

	public static function count_c($filter = array()) {
		$query = self::selectRaw('count(id) as total');

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(created_at) >= "' . $filter['date_from'] . '" AND DATE(created_at) <= "' . $filter['date_to'] . '"');
		}

		return $query->first()->total;
	}
}
