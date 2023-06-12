<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\DB;

class LogIpAddress {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (!$request->ajax()) {

			// Save the IP address to the database
			DB::table('ip_addresses')->insert(['ip_address' => $request->ip(),
				'url' => $request->url()]);
		}

		return $next($request);
	}
}
