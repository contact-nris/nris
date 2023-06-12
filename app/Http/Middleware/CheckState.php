<?php

namespace App\Http\Middleware;

use Closure;

class CheckState {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if ($request->segment(2) == 'update_ad' || $request->segment(2) == 'ad-delete') {
			return $next($request);
		} else if (!$request->req_state) {
			return redirect('/')->with('error', "You must have to select State Before create post");
		}
		return $next($request);
	}
}
