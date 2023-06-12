<?php

namespace App\Http\Controllers;

use App\BlogLike;
use App\NrisLIke;
use App\VideoLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class LikeController extends Controller {

	public function likeToggle(Request $request, $model_id) {
		$json = array();
		$data = $request->all();
		// dd($data);
		$user_id = auth()->user()->id;

		$rules = array(
			'model' => 'required',
		);

		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			$json['errors'] = api_error_format($validator->errors()->messages());
		} else {
			$model = false;

			switch ($request->model) {
			case 'blog':
				$model = BlogLike::firstOrCreate(array(
					'blog_id' => $model_id,
					'user_id' => $user_id,
				));
				break;
			case 'NrisTalk':
				$model = NrisLIke::firstOrCreate(array(
					'talk_id' => $model_id,
					'user_id' => $user_id,
				));
				break;
			case 'video':
				$model = VideoLike::firstOrCreate(array(
					'video_id' => $model_id,
					'user_id' => $user_id,
				));
				break;

			default:die("model not found");
				break;
			}

			if ($request->status == 'true') {
				if ($model->status == 1) {
					$model->status = -1;
				} else {
					$model->status = 1;
				}
			} else if ($request->status == 'false') {
				if ($model->status == 0) {
					$model->status = -1;
				} else {
					$model->status = 0;
				}
			}

			$model->save();

			$json['status'] = $model->status;
			switch ($request->model) {
			case 'blog':
				$json['totals'] = likeDislike(BlogLike::selectRaw('COUNT(status) as total, status')->where('blog_id', $model_id)->where('status', '>=', 0)->groupBy('status')->get());
				break;
			case 'NrisTalk':
				$json['totals'] = likeDislike(NrisLIke::selectRaw('COUNT(status) as total, status')->where('talk_id', $model_id)->where('status', '>=', 0)->groupBy('status')->get());
				break;
			case 'video':
				$json['totals'] = likeDislike(VideoLike::selectRaw('COUNT(status) as total, status')->where('video_id', $model_id)->where('status', '>=', 0)->groupBy('status')->get());
				break;
			}

			$json['success_message'] = $model->status == 1 ? 'You liked it' : ($model->status == 0 ? 'You disliked it' : '');
		}

		return $json;
	}
}
