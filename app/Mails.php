<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mails extends Model {
	public static function send($data) {
		$mail = new PHPMailer(true);

		$emails = [];
		if (is_array($data['to'])) {
			$emails = $data['to'];
		} else {
			$emails = [$data['to']];
		}

		try {
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->Host = env('MAIL_HOST');
			$mail->Port = env('MAIL_PORT');
			$mail->SMTPSecure = env('MAIL_ENCRYPTION');
			$mail->SMTPAuth = true;
			$mail->Username = env('MAIL_USERNAME');
			$mail->Password = env('MAIL_PASSWORD');

			$mail->addReplyTo('mailnris@gmail.com', 'Nris');
			$mail->setFrom(env('MAIL_FROM_ADDRESS'), 'Nris');
			foreach ($emails as $val) {
				$mail->AddBCC($val);
			}
			$mail->Subject = $data['subject'];
			$mail->IsHTML(true);
			$mail->msgHTML($data['content']);
			$mail->AltBody = $data['content'];

			if (isset($data['cc']) && is_array($data['cc'])) {
				foreach ($data['cc'] as $cc) {
					$mail->addCC($cc);
				}
			}
			$mail->send();

			return 1;
		} catch (Exception $e) {
			return $json['error'] = 'Message could not be sent. ' . $e->getMessage();
		}
	}
}