<?php

namespace App;

use App\Batchescategory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Batche extends Model {
	public $table = 'batches';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function getImageUrlAttribute() {
		return $this->image ? asset('upload/batches/' . $this->image) : '';
	}

	public static function BatchesData($limit = 10, $country_id = "") {
		$data = new stdClass();
		$category = Batchescategory::all();
		foreach ($category as $key => $cate) {
			$query = self::where('display_status', 1)->where('category', $cate->id);
			$query->where('batches.state_code', $country_id['code']);

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