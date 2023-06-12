<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model {
	public $table = 'business_hours';
	protected $casts = [];
	protected $appends = [];
	protected $fillable = ['model', 'model_id'];

	public static function sync($model, $model_id, $request) {
		$time = self::firstOrCreate([
			'model' => $model,
			'model_id' => $model_id,
		]);

		$keys = array(
			'sun_open' => 'sun',
			'sun_close' => 'sun',
			'mon_open' => 'mon',
			'mon_close' => 'mon',
			'tue_open' => 'tue',
			'tue_close' => 'tue',
			'wed_open' => 'wed',
			'wed_close' => 'wed',
			'thu_open' => 'thu',
			'thu_close' => 'thu',
			'fri_open' => 'fri',
			'fri_close' => 'fri',
			'sat_open' => 'sat',
			'sat_close' => 'sat',
		);

		foreach ($keys as $key => $day) {
			$field_key = 'business_hours_' . $key;
			$time->{$key} = $request->{$field_key} ? $request->{$field_key} : null;
		}
		$time->is24 = $request->is24 ? $request->is24 : 0;

		return $time->save();
	}
}
