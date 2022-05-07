<?php
session_start();
if (
  !isset($_SESSION['contact_flg']) ||
  (isset($_SESSION['contact_flg']) && $_SESSION['contact_flg'] !== 2)
) {
  // 正規の遷移でない場合コンタクト画面に強制移動
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/kenshin-daikou/");
  exit;
} else {
  $_SESSION = array(); // セッション変数解除
  // Cookie削除
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
  }
  // セッション破壊
  session_destroy();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width-device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>お問い合せを受け付けました。 Medical Support</title>
  <meta name="description" content="お問い合せを受け付けました。 Medical Support" />
  <meta name="keywords" content="健診代行ならメイサービス Medical Support" />
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:700&display=swap&subset=japanese" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
  <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/gotham" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" />
  <link rel="stylesheet" href="/kenshin-daikou/assets/css/estimate-thanks.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body id="body">
  <div id="wrapper">
    <header id="header">
      <div class="header__items flex is-between">
        <div class="header__left flex">
          <div class="header__logo"></div>
        </div>
        <div class="header__right flex">
          <a href="/kenshin-daikou/shiryou/#shiryou/" target="_top" class="download__document" onmousedown=""></a>
          <a href="/kenshin-daikou/#estimate" target="_top" class="estimate__link" onmousedown=""></a>
        </div>
      </div>
    </header>

    <main>
      <section id="download">
        <p class="category">THANK YOU</p>
        <h2>お問い合せを受け付けました。</h2>
        <div class="download__content-box flex is-center">
          <div class="download__message">
            <p>
              担当者より内容を確認の上、2~3営業日以内にご連絡いたします。確認のため、お客様へ自動返信メールをお送りさせていただきました。
            </p>
            <p>
              確認メールが来ていない場合、ご記入いただいたメールアドレスに間違いがある可能性がございますので、お手数ですが、その際は再度ご記入いただきますようお願いいたします。
            </p>
            <p>お問い合わせいただき、ありがとうございました。</p>
            <p class="download__staff">株式会社メイサービス　スタッフ一同</p>
          </div>
        </div>
        <a href="/kenshin-daikou/" target="_top" class="return-to-top flex is-center" onmousedown="">
          <img src="/kenshin-daikou/assets/img/common/top.png" alt="top" />
        </a>
      </section>
    </main>

    <footer>
      <div id="footer" class="footer">
        <div class="footer__content-box flex is-between top-only">
          <div class="footer__privacy-policy-link-box">
            <a href="https://www.meiservice.com/privacy-policy" target="_blank" class="privacy-policy" onmousedown="">個人情報保護方針</a>
            <a href="https://www.meiservice.com/privacy-policy/treatment" target="_blank" class="privacy-policy-treatment" onmousedown="">個人情報保護に関する弊社の取り扱い</a>
          </div>
          <div class="footer__address">
            COPYRIGHT(C) MEISERVICE co.,ltd ALL RIGHTS RESERVED.
          </div>
        </div>
      </div>
    </footer>
  </div>
</body>

</html>