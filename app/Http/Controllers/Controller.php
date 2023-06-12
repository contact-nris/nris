<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	function clean($string) {
		$search = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç',
			'È', 'É', 'Ê', 'Ë',
			'Ì', 'Í', 'Î', 'Ï',
			'Ð', 'Ñ',
			'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø',
			'Ù', 'Ú', 'Û', 'Ü',
			'Ý', 'Þ', 'ß',
			'à', 'á', 'â', 'ã', 'ä', 'å', 'æ',
			'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï',
			'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø',
			'ù', 'ú', 'û', 'ü',
			'ý', 'þ', 'ÿ', '@');
		$replace = array(
			'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c',
			'e', 'e', 'e', 'e',
			'i', 'i', 'i', 'i',
			'd', 'n',
			'o', 'o', 'o', 'o', 'o', '', 'o',
			'u', 'u', 'u', 'u',
			'y', 'th', 'ss',
			'a', 'a', 'a', 'a', 'a', 'a', 'ae',
			'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i',
			'd', 'n', 'o', 'o', 'o', 'o', 'o', '', 'o',
			'u', 'u', 'u', 'u',
			'y', 'th', 'y', 'at');
		$string = str_replace($search, $replace, $string);

		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

		return preg_replace('/-+/', '', strtolower($string)); // Replaces multiple hyphens with single one.
	}
	
	function check_title_slug($table,$matchingRecords,$rcol,$ocol){
	    	$matchingCount = $matchingRecords->count();
			if ($matchingCount > 0) {
				$new_title = $this->get_uniq_slug($rcol);
			} else {
				$new_title =$rcol;
			}

			if ($id > 0) {
				if (trim($rcol) != $ocol) {
					$rcol = $new_title;
					$table->url_slug = $this->clean($new_title);
				}} else {
				$table->title = $new_title;
				$table->url_slug = $this->clean($new_title);
			}
			return $table;
	}
	    
	

}
