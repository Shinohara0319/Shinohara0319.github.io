<?php

class SendEmail
{
	function __construct()
	{
	}

	public function sendContactToAdmin($data) {
		try {
			$from = 'yoshinori.shinohara@cirqua.co.jp';

			mb_language("JA");
			mb_internal_encoding("UTF-8");

			$header  = 'From:' . mb_encode_mimeheader("フォーム送信テスト") . '<' . $from . '>' . "\n";
			$subject = 'お問い合わせがありました ' ;
			$body = $this->buildBodyContact('admin', $data);

			mb_send_mail($data['your-email'], $subject, $body, $header);

			return true;
		} catch (Exception $e) {
			$_SESSION['contact']['error'] = '電子メールが失敗しました。';
		}

		return false;
	}

	public function sendContactToUser($data) {
		try {
			$from = 'yoshinori.shinohara@cirqua.co.jp';

			mb_language("JA");
			mb_internal_encoding("UTF-8");
			$header  = 'From:' . mb_encode_mimeheader("フォーム送信テスト") . '<' . $from . '>' . "\n";

			$subject = 'お問い合わせいただきありがとうございます';
			$body = $this->buildBodyContact('user', $data);

			mb_send_mail($data['your-email'], $subject, $body, $header);

			return true;
		} catch (Exception $e) {
			$_SESSION['contact']['error'] = '電子メールが失敗しました。';
		}

		return false;
	}

	private function buildBodyContact($type, $data) {
		if ($type == 'admin') {
			$body = $this->load_body_contact_admin();
		} else {
			$body = $this->load_body_contact_user();
		}

		$body = str_replace('%busyo%', $data['your-busyo'], $body);
		$body = str_replace('%sei%', $data['your-sei'], $body);
		$body = str_replace('%mei%', $data['your-mei'], $body);
		$body = str_replace('%email%', $data['your-email'], $body);
		$body = str_replace('%company%', $data['your-company'], $body);
		$body = str_replace('%tel%', $data['your-tel'], $body);

		return $body;
	}

	/**
	*
	* @return string
	*/
	private function load_body_contact_admin() {
		return
<<< EOM


お客様からお問い合わせがありました。
※本メールは、プログラムから自動で送信しています。

以下お客様情報です。
----------------------------------------------------

【会社名】		%company%
【部署名】		%busyo%
【担当名】		%sei% %mei%
【メールアドレス】	%email%
【電話番号】		%tel%

----------------------------------------------------

お客様への折り返しのご連絡を宜しくお願い致します。
EOM;
	}

	private function load_body_contact_user() {
		return
<<< EOM

%sei%　%mei%様

この度は　フォーム送信テスト　へ
お問い合わせいただき誠にありがとうございます。

下記の内容を確認させて頂いた後、
折り返し担当よりご連絡をさせていただきます。
宜しくお願いします。

------------------------------------------------------

【会社名】		%company%
【部署名】		%busyo%
【担当名】		%sei% %mei%
【メールアドレス】	%email%
【電話番号】		%kana%

------------------------------------------------------

尚、3日経ってもご連絡がない場合、
何かの問題でメールが届いていない可能性があります。
大変恐縮ですが、その際は下記お電話番号まで
ご連絡をいただけますと幸いです。
【　000-0000-0000　】

※本メールは、プログラムから自動で送信しています。
心当たりの無い方は、お手数ですが削除してください。
もしくは、そのまま送信元に返信していただければと思います。

=======================================================
フォーム送信テスト
　　http://www.xxx.xxx

〒000-00000　東京都xxxxxxxxxx
TEL：000-0000-0000
FAX：000-0000-0000
=======================================================
EOM;
	}
}
