<?php

class SendEmailEstimate
{
	function __construct()
	{
	}

	public function sendContactToAdmin($data)
	{
		try {
			$from = $data['your-email'];

			mb_language("JA");
			mb_internal_encoding("UTF-8");

			$header  = 'From:' . mb_encode_mimeheader("メイサービスお見積りお問い合せ") . '<' . $from . '>' . "\n";
			$subject = 'お問い合わせがありました ';
			$body = $this->buildBodyContact('admin', $data);

			mb_send_mail('info-co@meiservice.com', $subject, $body, $header);

			return true;
		} catch (Exception $e) {
			$_SESSION['contact']['error'] = '電子メールが失敗しました。';
		}

		return false;
	}

	public function sendContactToUser($data)
	{
		try {
			$from = 'info-co@meiservice.com';

			mb_language("JA");
			mb_internal_encoding("UTF-8");
			$header  = 'From:' . mb_encode_mimeheader("メイサービスお見積りお問い合せ") . '<' . $from . '>' . "\n";

			$subject = 'メディカルサポートにお問い合わせいただきありがとうございます。';
			$body = $this->buildBodyContact('user', $data);

			mb_send_mail($data['your-email'], $subject, $body, $header);

			return true;
		} catch (Exception $e) {
			$_SESSION['contact']['error'] = '電子メールが失敗しました。';
		}

		return false;
	}

	private function buildBodyContact($type, $data)
	{
		if ($type == 'admin') {
			$body = $this->load_body_contact_admin();
		} else {
			$body = $this->load_body_contact_user();
		}

		$body = str_replace('%company%', $data['your-company'], $body);
		$body = str_replace('%staffNumber%', $data['your-staffNumber'], $body);
		$body = str_replace('%sei%', $data['your-sei'], $body);
		$body = str_replace('%mei%', $data['your-mei'], $body);
		$body = str_replace('%tel%', $data['your-tel'], $body);
		$body = str_replace('%email%', $data['your-email'], $body);

		return $body;
	}

	/**
	 *
	 * @return string
	 */
	private function load_body_contact_admin()
	{
		return
			<<< EOM


お客様からお問い合わせがありました。
※本メールは、プログラムから自動で送信しています。

以下お客様情報です。
----------------------------------------------------

【会社名】		%company%
【従業員数】		%staffNumber%
【担当名】		%sei% %mei%
【メールアドレス】	%email%
【電話番号】		%tel%

----------------------------------------------------

お客様への折り返しのご連絡を宜しくお願い致します。
EOM;
	}

	private function load_body_contact_user()
	{
		return
			<<< EOM

%company%  %sei%　%mei% 様

※このメールはシステムからの自動返信です

この度は、メディカルサポートへお問い合わせいただき誠にありがとうございます。
以下の内容でお問い合わせを受け付けいたしました。
3営業日以内に担当者よりご連絡いたしますので今しばらくお待ちください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
会社名：%company%
従業員数：%staffNumber%
電　話：%tel%
ご担当者：%sei% %mei% 様
メール：%email%
…………………………………………………………………………………
●個人情報に関する確認・同意
個人情報保護方針に同意しました。
個人情報の保護に関する弊社の取扱いに同意しました。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

弊社担当者から連絡がない場合システムエラー等の可能性がございますので、誠に恐縮ですが以下の電話もしくはメールにてお知らせください。

…………………………………………………………………………………
●お電話でお問い合わせ
TEL:052-522-7241
受付時間/9:00〜18:00(土日・祝日定休)
…………………………………………………………………………………
●メールでお問い合わせ
info-co@meiservice.com


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
株式会社メイサービス

【本社】〒451-0075 名古屋市西区康生通二丁目20番1号
【東京オフィス】〒101-0052 東京都千代田区神田小川町二丁目3番地13 M&Cビル 2階
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
https://www.meiservice.com

EOM;
	}
}
