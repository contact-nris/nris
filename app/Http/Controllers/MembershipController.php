<?php

namespace App\Http\Controllers;

use App\NRICard;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller {

	private function cardNumber($min = 1111111111111111, $max = 9999999999999999, $quantity = 1) {
		return (string) rand($min, $max);
	}

	public function startPayment(Request $request, $cardType = 'yearly') {

		$card = new NRICard;
		$card->user_id = $request->user()->id;
		$card->card_no = $this->cardNumber();
		$card->card_type = $cardType == 'yearly' ? 1 : 2;
		$card->fname = $request->user()->first_name;
		$card->lname = $request->user()->last_name;
		$card->dob = $request->user()->dob;
		$card->email = $request->user()->email;
		$card->address = '';
		$card->expiry_date = $cardType == 'yearly' ? date("Y-m-d", strtotime('+1 year')) : date("Y-m-d", strtotime('+100 year'));
		$card->status = 0;
		$card->country = $request->user()->country;
		$card->image = '';
		$card->save();

		$data['item'] = $cardType . '-' . $card->id;

		return view('front.paypal.membership_plan_buy', $data);
	}

	// 'meta_title' => $data['blog']->meta_title,
	//            'meta_description' => $data['blog']->meta_description,
	//            'meta_keywords' => $data['blog']->meta_keywords,

	public function index(Request $request) {
		$data['meta_tags'] = array(
			'title' => 'NRIs Card ',
			'description' => 'Buy/Sell Cars, automobiles at best prices with exciting offers and deals. Just select your state and find the latest auto Ads for cars, autos in USA.',
			'twitter_title' => 'NRIs Card | NRIS',
			'image_' => '',
			'keywords' => 'Indian websites in USA, NRI websites, Indian community websites, classified website for NRIS in USA, free ads website',
		);

		$id = Auth::user()->id;
		$data['user_data'] = User::where('id', $id)->first();

		return view('front.membership_plan', $data);
	}

	public function fun_return(Request $request) {
		die('fun_return');
	}

	public function fun_cancel_return(Request $request) {
		die('fun_cancel_return');
	}

	public function fun_notify_url(Request $request) {
		$post = $_POST;
		$request_data = 'cmd=_notify-validate';

		foreach ($post as $key => $value) {
			$request_data .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
		}

		if (config('paypal.test_mode') == "1") {
			$curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
		} else {
			$curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
		}

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request_data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($curl);

		if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && $post['payment_status'] == 'Completed') {

			$payment = \App\Paypal::firstOrCreate(array(
				'txn_id' => $request->txn_id,
			));

			$payment->user_id = (int) $post['custom'];
			$payment->amount = (float) $post['mc_gross'];
			$payment->currency = $post['mc_currency'];
			$payment->payer_email = $post['payer_email'];
			$payment->payer_status = $post['payer_status'];
			$payment->payment_status = strtolower($post['payment_status']);
			$payment->txn_id = $post['txn_id'];
			$payment->item_type = "NIRS Card";
			$payment->response = $request->all();
			$payment->save();

			list($item_name, $card_id) = explode('-', $request->item_number);
			$card = NRICard::find($card_id);
			if ($card) {
				$card->payment_id = $payment->id;
				$card->status = 1;
				$card->save();
			}

			echo "ok";
		}

		curl_close($curl);
	}

	public function payment(Request $request) {
		$enableSandbox = true;

		// PayPal settings. Change these to your account details and the relevant URLs
		// for your site.
		$paypalConfig = [
			'email' => 'paynris@gmail.com',
			'return_url' => route('success.payment'),
			'cancel_url' => route('cancle.payment'),
			'notify_url' => route('membership.pay'),
		];

		$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

		// Product being purchased.
		$itemName = $request->item_number == 'yearly' ? 'yearly' : 'lifetime';
		$itemAmount = $request->item_number == 'yearly' ? '$10' : '$100';

		// Check if paypal request or response
		if (!isset($request->txn_id) && !isset($request->txn_type)) {
			echo "enter done";
			// Grab the post data so that we can set up the query string for PayPal.
			// Ideally we'd use a whitelist here to check nothing is being injected into
			// our post data.
			$data = [];
			foreach ($request->all() as $key => $value) {
				$data[$key] = stripslashes($value);
			}

			// Set the PayPal account.
			$data['business'] = $paypalConfig['email'];

			// Set the PayPal return addresses.
			$data['return'] = stripslashes($paypalConfig['return_url']);
			$data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
			$data['notify_url'] = stripslashes($paypalConfig['notify_url']);

			// Set the details about the product being purchased, including the amount
			// and currency so that these aren't overridden by the form data.
			$data['item_name'] = $itemName;
			$data['amount'] = $itemAmount;
			$data['currency_code'] = 'USD';

			// Add any custom fields for the query string.
			$data['custom'] = Auth::user()->id;
			// echo $data['amount'];
			// Build the query string from the data.
			$queryString = http_build_query($data);
			// Redirect to paypal IPN
			echo '<pre>';
			print_r($queryString);
			echo '</pre>';
			header('location:' . $paypalUrl . '?' . $queryString);
			exit();

		} else {
			// Handle the PayPal response.

			// Assign posted variables to local data array.
			$data = [
				'item_name' => $request->item_number == 'yearly' ? 'yearly' : 'lifetime',
				'item_number' => "NIRs CARD",
				'payment_status' => $request->payment_status,
				'payment_amount' => $request->item_number == 'yearly' ? '$10' : '$100',
				'payment_currency' => 'USD',
				'txn_id' => $request->txn_id,
				'receiver_email' => Auth::User()->email,
				'payer_email' => 'paynris@gmail.com',
				'custom' => $request->custom,
			];

			// We need to verify the transaction comes from PayPal and check we've not
			// already processed the transaction before adding the payment to our
			// database.
			if (verifyTransaction($request->all()) && checkTxnid($data['txn_id'])) {
				if (addPayment($data) !== false) {
					echo "Payment successfully added";die;
				}
			}
		}
	}
}