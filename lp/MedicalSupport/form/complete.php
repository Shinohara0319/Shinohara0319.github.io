<?php
session_start();
if ( !isset($_SESSION['contact_flg']) ||
    ( isset($_SESSION['contact_flg']) && $_SESSION['contact_flg'] !== 2) ) {
  // 正規の遷移でない場合コンタクト画面に強制移動
  header("Location: http://".$_SERVER["HTTP_HOST"]."/index.php");
  exit;
}else{
  $_SESSION = array(); // セッション変数解除
  // Cookie削除
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
  }
  // セッション破壊
  session_destroy();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>お問い合わせ完了</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&display=swap&subset=japanese" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@200&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/common.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

  <body>
    <div class="wrap">
      <!-- ヘッダー(下層) -->
      <header class="header sub">
        <div class="header_pc inner">
          <div class="header_bg inner_min">
            <div class="header_box flex is_between">
              <h1 class="logo">
                テンプレート
              </h1>
              <div class="right flex">
                <div class="tel_content">
                  <p class="tel"><a class="tellink" href="tel:000-0000-0000">000-0000-0000</a></p>
                  <p class="txt">受付時間 12:00～18:00(土日祝除く）</p>
                </div>
                <div class="contact">
                  <a href="">お問い合わせ</a>
                </div>
              </div>
            </div>
            <div class="header_nav">
              <ul class="flex">
                <li><a href="">ダミーダミー</a></li>
                <li><a href="">ダミーダミー</a></li>
                <li class="header_list">
                  <p class="accd_main js_accd">ダミーダミー</p>
                  <ul class="accd_list">
                    <li><a href="">ダミーダミー</a></li>
                    <li><a href="">ダミーダミー</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="header_sp">
          <div class="header_sp_inner flex">
            <h1 class="sp_logo">
              テンプレート
            </h1>
            <div class="contact">
              <a href="">お問い合わせ</a>
            </div>
            <div id="btnTrigger" class="header_spnavbtn modalOpner modalCloser">
              <span class="one"><!--btn--></span>
              <span class="two"><!--btn--></span>
              <span class="three"><!--btn--></span>
            </div>
          </div>
        </div>
        <div id="drawermenu">
          <div class="drawbox">
            <ul class="draw_list">
              <li class="list"><a class="link" href="">ダミーダミー</a></li>
              <li class="list"><a class="link" href="">ダミーダミー</a></li>
              <li class="list">
                <p class="list_accd">ダミー</p>
                <ul class="accd_list">
                  <li><a class="link" href="">ー　ダミーダミー</a></li>
                  <li><a class="link" href="#">ー　ダミーダミー</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </header>

      <div class="page_contact">
        <nav class="inner_min">
          <ol class="breadcrumbs">
            <li><a href="../index.html">TOPページ</a></li>
            <li><a href="./index.html">お問い合わせ</a></li>
            <li>送信完了</li>
          </ol>
        </nav>

        <div class="common_contact contact_complete">
          <div class="inner_min">
            <h1 class="common_ttl">
              <span class="sub_ttl">CONTACT /お問い合わせ</span> 送信完了
            </h1>
            <div class="contact_box">
              <div class="complete_textbox">
                <h2 class="complete_ttl">
                  弊社へお問い合わせいただきまして、<br>誠にありがとうございます。
                </h2>
                <p class="complete_txt">お問い合わせいただきました内容を確認後、担当者より改めてご連絡いたします。</p>
                <p class="complete_txt">
                  ※送信エラーもしくは、弊社のご連絡が3日経ってもとどかない場合は、<br> お手数ですが、お電話にてご連絡くださいませ。
                </p>
                <div class="tel_content">
                  <p class="tel"><a class="tellink" href="tel:000-0000-0000">000-0000-0000</a></p>
                  <p class="txt">受付時間 12:00～18:00(土日祝除く）</p>
                </div>
                <div class="submit_box">
                  <div class="btn_in">
                    <a href="index.php" class="back_btn">TOPへ戻る</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- フッター(下層) -->
      <footer class="footer">
        <div class="footer_btm">
          <p class="copy">Copyright All Rights Reserved.</p>
        </div>
      </footer>
    </div>
  </body>
</html>