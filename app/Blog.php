<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model {
	public $table = 'blogs';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function blog_like() {
		return $this->hasMany('App\BlogLike', 'blog_id')->where('status', '1');
	}
	public function blog_dislike() {
		return $this->hasMany('App\BlogLike', 'blog_id')->where('status', '0');
	}

	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->description), 100, '...');
	}

	public function getImageUrlAttribute() {
		return $this->image ? assets_url('upload/blog/' . $this->image) : '';
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}

	public static function count_c($filter = array()) {
		$query = self::selectRaw('count(id) as total');

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(created_at) >= "' . $filter['date_from'] . '" AND DATE(created_at) <= "' . $filter['date_to'] . '"');
		}

		return $query->first()->total;
	}

	public static function BlogData($limit = 10) {
		$query = self::selectRaw('blogs.*,blogs_categoires.name as category_name')
			->leftJoin(
				'blogs_categoires',
				'blogs_categoires.id',
				'blogs.category_id'
			)
			->where(
				array('blogs.status' => 1, 'blogs.visibility' => 'Public')
			)
			->orderBy(
				'blogs.created_at',
				'desc'
			)
			->limit(
				$limit
			);

		return $query->get();
	}
}