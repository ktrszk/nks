<?php

require_once($DIR_INC."_inc/phpmailer/class.phpmailer.php");

class Mail {
	private $MAIL_SENDER = "NKSコーポレーション";	// 送信者名
	private $MAIL_FROM = "hp-kanri@nkscorp.com";	// 送信者アドレス
	private $err;
	
	// エラーを返す
	public function get_error() {
		return $this->err;
	}
	
	// メール本文作成
	private function get_mailbody($id, $post) {
		global $DIR_HTTP, $DIR_HTTPS, $DEMO_PATH, $USER_PATH, $MAIL_SIGN;
		
		$obj = array();
		$obj['mng'] = array();
		$obj['usr'] = array();
		
		/* お問い合わせ
		---------------------------------------------------------------------------------------------------- */
		if ($id == "contact") {
			global $CATEGORY_LIST;
			
			$fullname = $post['name01'].'　'.$post['name02'];
			$tel = (!empty($post['tel1'])) ? $post['tel1'].'-'.$post['tel2'].'-'.$post['tel3'] : '';
			$category = "";
			if (is_array($post['category'])) {
				$cnt = 0;
				for ($i=0; $i<count($CATEGORY_LIST); $i++) {
					if (in_array($CATEGORY_LIST[$i],$post['category'])) {
						if ($cnt > 0) $category .= '、';
						$category .= $CATEGORY_LIST[$i];
						$cnt ++;
					}
				}
			}
			
			$body = <<<EOL
==================================
       お問い合わせ内容
==================================

【氏名】{$fullname}

【氏名フリガナ】{$post['kana01']}　{$post['kana02']}

【会社 / 団体名】{$post['company']}

【部署名】{$post['division']}

【メールアドレス】{$post['email']}

【連絡先電話番号】{$tel}

【お問い合わせ内容】
{$category}

{$post['message']}

EOL;
			// 管理者用
			$obj['mng']['sender'] = $fullname;
			$obj['mng']['from'] = $post['email'];
			$obj['mng']['to'] = $this->MAIL_FROM;
			$obj['mng']['subject'] = "【ホームページからの問い合わせ】：".$fullname." 様より";
			$obj['mng']['body'] = <<<EOL
ホームページより問い合わせがありました。
下記内容を確認の上、ご連絡お願いします。

{$body}

{$MAIL_SIGN}
EOL;
			// 利用者用
			$obj['usr']['sender'] = $this->MAIL_SENDER;
			$obj['usr']['from'] = $this->MAIL_FROM;
			$obj['usr']['to'] = $post['email'];
			$obj['usr']['subject'] = '【'.$this->MAIL_SENDER.'】お問い合わせありがとうございます';
			$obj['usr']['body'] = <<<EOL
{$fullname} 様

お問い合わせありがとうございます。
改めて担当者よりご連絡差し上げます。
よろしくお願いいたします。


※本メールは自動配信メールです
{$body}

{$MAIL_SIGN}
EOL;
			
		}
		
		//$obj['mng']['to'] = 'k@keitarosuzuki.com';
		
		return $obj;
	}
	
	// メール送信
	public function send_mail($id, $post) {
		$mailbody = $this->get_mailbody($id, $post);
		
		if ($this->send_system_mail($mailbody['usr']['to'], $mailbody['usr']['subject'], $mailbody['usr']['body'], $mailbody['usr']['sender'], $mailbody['usr']['from'])
			&& $this->send_system_mail($mailbody['mng']['to'], $mailbody['mng']['subject'], $mailbody['mng']['body'], $mailbody['mng']['sender']."様", $mailbody['mng']['from'])) {
			
			return TRUE;
			
		} else {
			$this->err = "メール送信に失敗しました";
			return FALSE;
		}
	}
	
	// メール送信：宛先が空の場合は無視する
	private function send_system_mail($to, $subject, $body, $sender, $from) {
		global $MAIL_ON, $ENC_PHP;
		
		if (!empty($to) && !empty($body)) {
			//echo $body;
			
			if ($MAIL_ON) {
				mb_language("japanese");
				mb_internal_encoding($ENC_PHP);
				
				$mail = new PHPMailer();
				$mail->CharSet = "iso-2022-jp";
				$mail->Encoding = "7bit";
				$mail->AddAddress($to);
				$mail->From = $from;
				$mail->FromName = mb_encode_mimeheader($sender);
				$mail->Subject = mb_encode_mimeheader($subject);
				$mail->Body  = mb_convert_encoding(convert_to_mail($body),"JIS",$ENC_PHP);
				
				return $mail->Send();
			} else {
				return TRUE;
			}
			
		} else {
			return TRUE;
		}
	}
}

?>