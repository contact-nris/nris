<?php

namespace App;

use App\RatingSource;
use Illuminate\Database\Eloquent\Model;

class MovieExternalRating extends Model {
	public $table = 'movies_external_rating';
	protected $casts = [
		'rating_data' => 'array',
	];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public static function MovieExternalRatingData($limit = 10) {
		$data = [];
		$data['lists'] = self::selectRaw('*')->where('status', 'Active')
			->orderBy('created_at', 'desc')
			->limit($limit)
			->get();

		$data['rating_source'] = RatingSource::all()->keyBy('id');

		return $data;
	}
}
