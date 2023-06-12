<?php

namespace App\Http\Middleware;

use App\Country;
use App\State;
use Closure;

class Subdomain {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$current_url = $_SERVER['HTTP_HOST'];
		$curr_url_array = explode('.', $_SERVER['HTTP_HOST']);

		$subdomain = $curr_url_array[0];
		if ($subdomain == 'www') {
			$subdomain = $curr_url_array[1];
		}

		$country = Country::where('domain', 'like', $subdomain)->first();
		if ($country) {
			$request->merge(['req_country' => $country->toArray()]);
		} else {
			$state = State::selectRaw('states.*, countries.name as country_name, countries.code as country_code')->leftJoin('countries', 'countries.id', 'states.country_id')->where('states.domain', 'like', $subdomain)->first();

			if ($state) {
				$request->merge(['req_state' => $state->toArray()]);

				$country = Country::where('name', 'like', $state->country_name)->first();
				$request->merge(['req_country' => $country->toArray()]);
			}
		}

		return $next($request);
	}
}
