<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model {
	protected $casts = [];

	protected $appends = [
		'logo_url',
		'header_image_url',
	];

	public function remove() {
		$this->delete();
	}

	public function getLogoUrlAttribute() {
		return $this->logo ? url('upload/state/' . $this->logo) : '';
	}

	public function getHeaderImageUrlAttribute() {
		return $this->header_image ? url('upload/state/' . $this->header_image) : '';
	}

	public function getHeaderImage2UrlAttribute() {
		return $this->header_image2 ? url('upload/state/' . $this->header_image2) : '';
	}

	public function getHeaderImage3UrlAttribute() {
		return $this->header_image3 ? url('upload/state/' . $this->header_image3) : '';
	}
}
