<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SubscribeNewsletter;
use Illuminate\Http\Request;

class SendEmailListController extends Controller {

	public function index(Request $request) {
		$query = SubscribeNewsletter::where('status', 0);

		if ($request->filter_name) {
			$query->where('subscribe_newsletters.email', 'like', '%' . $request->filter_name . '%');
		}

		if ($request->mailinit == 'true') {
			$data['total_user'] = $query->count();
			$data['html'] = view('admin.send_email.mail', $data)->render();

			return $data;
		}

		if ($request->mailsubmit == 'true') {
			$total_user = $query->get();
			foreach ($total_user as $value) {
				$emails = $value['email'];
			}

			\App\Mails::send(array(
				'to' => $emails,
				'subject' => $request->subject,
				'content' => $request->content,
			));

			$data['success_message'] = 'Mail sent Successfully';

			return $data;
		}

		$data['lists'] = $query->paginate();
		return view('admin.send_email.index', $data);
	}

	public function deleteItem(Request $request, $id) {
		$data = $request->all();
		$educationTeaching = SubscribeNewsletter::findOrNew($id);
		$educationTeaching->delete();

		\Session::flash('success', 'Newsletter Email Deleted Successfully.');
		return redirect()->back();
	}

}

?>