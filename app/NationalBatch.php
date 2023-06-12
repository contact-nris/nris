<?php

namespace App;

use App\BatchCategory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class NationalBatch extends Model {
	public $table = 'national_batches';
	protected $casts = [];
	protected $appends = [
		'image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {

		// return 'https://www.nris.com/sumd2014/upload/blog/19685_Casino%20-%20Blackjack-players_e0b0fbf5-840f-404d-bba5-bee0203c8c43.jpg';

		return $this->image ? asset('upload/national_batches/' . $this->image) : '';

	}
	public static function BatcheData($limit = 10, $country_id = "") {
		$data = new stdClass();
		$category = BatchCategory::all();
		foreach ($category as $key => $cate) {
			$query = self::where('status', 1)->where('category', $cate->id);
			// ->orderBy("created_at", "Desc");
			$query->where('national_batches.country', $country_id);

			$data->batches[$cate->id] = $query->limit($limit)->get();
		}
		$data->category = $category;

		return $data;
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public function getShortTitleAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->title), 28, '...');

	}
}
