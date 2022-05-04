<?php
session_start();
if (
  !isset($_SESSION['contact_flg']) ||
  (isset($_SESSION['contact_flg']) && $_SESSION['contact_flg'] !== 2)
) {
  // 正規の遷移でない場合コンタクト画面に強制移動
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
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
  <title>ダウンロードありがとうございました。 Medical Support</title>
  <meta name="description" content="ダウンロードありがとうございました。 Medical Support" />
  <meta name="keywords" content="健診代行ならメイサービス Medical Support" />
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:700&display=swap&subset=japanese" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
  <link rel="stylesheet" href="../../../assets/css/shiryou-thanks.css" />
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
          <a href="../shiryou.php#shiryou" target="_blank" class="download__document"></a>
          <a href="../../../index.php#estimate" target="_blank" class="estimate__link"></a>
        </div>
      </div>
    </header>

    <main>
      <section id="thanks">
        <p class="category">THANK YOU</p>
        <h2>ダウンロードありがとうございました。</h2>
        <a href="../../../index.php" target="_top" class="return-to-top flex is-center">
          <img src="../../../assets/img/common/top.png" alt="top" />
        </a>
      </section>
    </main>

    <footer>
      <div id="footer" class="footer">
        <div class="footer__content-box flex is-between top-only">
          <div class="footer__privacy-policy-link-box">
            <a href="https://www.meiservice.com/privacy-policy/" target="_blank" class="privacy-policy">個人情報保護方針</a>
            <a href="https://www.meiservice.com/privacy-policy/treatment" target="_blank" class="privacy-policy-treatment">個人情報保護に関する弊社の取り扱い</a>
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