<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CityController extends Controller {
	public function AutoComplete(Request $request) {
		$json = array();
		$state_code = $request->state_code ? explode(',', $request->state_code) : array();
		$terms = $request->term;

		$query = City::selectRaw('*')
			->where('cities.name', 'like', '%' . $terms . '%')
			->orderBy('cities.name', 'ASC')
			->limit(10);

		if (empty($state_code)) {
			$query->where('cities.state_code', '!=', '');
		} else {
			$query->whereIn('cities.state_code', $state_code);
		}

		$cities = $query->get();

		foreach ($cities as $city) {
			$json[] = array(
				'id' => $city->id,
				'label' => $city->state_code.'->'.$city->name,
				'value' => $city->id,
				
			);
		}

		return $json;
	}

	public function autodropdown(Request $request) {
		$json = array();
		$terms = $request->term;
		$country_id = $request->req_country ? $request->req_country['id'] : 1;

		if ($request->req_state) {
			$citys = \App\City::selectRaw('name, id')->where('state_code', $request->req_state['code'])
				->where('cities.name', 'like', '%' . $terms . '%')
				->limit(50)->get()->toArray();
		} else {
			$citys = \App\City::selectRaw('CONCAT(cities.name," - ",states.name) as name, cities.id')
				->leftJoin('states', 'states.code', 'cities.state_code')
				->whereRaw('(cities.name like "%' . $terms . '%" OR states.name like "%' . $terms . '%")')
				->where('states.country_id', $country_id)->limit(50)->get()->toArray();
		}

		return $citys;
	}

}
