<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model {
	public $table = 'forums_thread';
	protected $casts = [];
	protected $appends = [];

	public function remove() {
		$this->delete();
	}

	public function getShortDescAttribute() {
		return \Illuminate\Support\Str::limit(strip_tags($this->description), 100, '...');
	}

	public static function count_c($filter = array()) {
		$query = self::selectRaw('count(id) as total');

		if (isset($filter['date_from'])) {
			$query->whereRaw('DATE(created_at) >= "' . $filter['date_from'] . '" AND DATE(created_at) <= "' . $filter['date_to'] . '"');
		}

		return $query->first()->total;
	}

	public function comments() {
		return $this->hasMany(ForumReply::class, 'forum_thread_id');
	}

	public static function ForumData($limit = 10) {
		$forum_data = array();

		$query = self::selectRaw('forums_thread.*, fpc.name as parent_cat_name, fc.name as cat_name')
			->leftJoin('forums_categoires as fc', 'fc.id', 'forums_thread.sub_category_id')
			->leftJoin('forums_parent_categoires as fpc', 'fpc.id', 'fc.parent_id')
			->limit($limit);

		$latest = clone $query;
		$forum_data['latest'] = $latest->orderBy('forums_thread.created_at', 'DESC')->get();

		$most_viewed = clone $query;
		$forum_data['top_viewed'] = $most_viewed->orderBy('forums_thread.total_views', 'DESC')->get();

		return $forum_data;
	}

	public function getSlugAttribute() {
		if (strlen($this->title) > 0) {
			return slug($this->title . '-' . $this->id);
		} else {
			return slug($this->title . '-' . $this->id);
		}
	}
}
