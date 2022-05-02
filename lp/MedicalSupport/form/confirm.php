<?php 
session_start();
if ( !isset($_SESSION['contact_flg']) ||
      ( isset($_SESSION['contact_flg']) && $_SESSION['contact_flg'] !== 1) ) {
  // 正規の遷移でない場合コンタクト画面に強制移動
  header("Location: http://".$_SERVER["HTTP_HOST"]."/index.html");
  exit;
}
if (isset($_POST) && count($_POST) > 0) {
  // フォームのボタンが押されたら
  if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    // フォームから送信されたデータを各変数に格納
      $company       = isset( $_POST[ 'your-company' ] ) ? $_POST[ 'your-company' ] : NULL;
      $busyo       = isset( $_POST[ 'your-busyo' ] ) ? $_POST[ 'your-busyo' ] : NULL;
      $sei       = isset( $_POST[ 'your-sei' ] ) ? $_POST[ 'your-sei' ] : NULL;
      $mei       = isset( $_POST[ 'your-mei' ] ) ? $_POST[ 'your-mei' ] : NULL;
      $email      = isset( $_POST[ 'your-email' ] ) ? $_POST[ 'your-email' ] : NULL;
      $tel       = isset( $_POST[ 'your-tel' ] ) ? $_POST[ 'your-tel' ] : NULL;
  
      //POSTされたデータをセッション変数に保存
      $_SESSION[ 'your-company' ]       = $company;
      $_SESSION[ 'your-busyo' ]       = $busyo;
      $_SESSION[ 'your-sei' ]       = $sei;
      $_SESSION[ 'your-mei' ]       = $mei;
      $_SESSION[ 'your-email' ]      = $email;
      $_SESSION[ 'your-tel' ]      = $tel;

    // 送信ボタンが押されたら
    if (isset($_POST["submit"])) {
      //メール送信処理
      require_once 'libs/SendEmail.php';
      //メール送信処理
      $mail = new SendEmail;
      $sendAdmin = $mail->sendContactToAdmin($_POST);
      $sendUser  = $mail->sendContactToUser($_POST);
      if ($sendAdmin && $sendUser) {
        //終了処理
        unset($_POST);
        $_SESSION['contact_flg'] = 2;
        // サンクスページに画面遷移させる
        header("Location: http://".$_SERVER["HTTP_HOST"]."/complete.php");
        exit;
      } else {
        $_SESSION['contact'] = $_POST;
        unset($_POST);
        header("Location: http://".$_SERVER["HTTP_HOST"]."/error.html");
        exit();
      }
    }
  }else{
    // POST遷移でない場合Sessionとクッキーを破棄してコンタクト画面に強制移動
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
    header("Location: http://".$_SERVER["HTTP_HOST"]."/index.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>お問い合わせ確認</title>
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
  <body>
    <div class="wrap">

      <div class="page_contact">
        <nav class="inner_min">
          <ol class="breadcrumbs">
            <li><a href="../index.html">TOPページ</a></li>
            <li><a href="./index.html">お問い合わせ</a></li>
            <li>送信確認</li>
          </ol>
        </nav>

        <div class="common_contact contact_confirm">
          <div class="inner_min">
            <h3 class="common_ttl">
              <span class="sub_ttl">CONTACT /お問い合わせ</span>
              入力内容のご確認
            </h3>
            <div class="contact_box">

              <div class="list flex is_between">
                <label for="your_company">会社名</label>
                <div class="input_list">
                  <div class="flex is_between">
                    <?php echo $company; ?>
                  </div>
                </div>
              </div>

              <div class="list flex is_between">
                <label for="your_busyo">部署名</label>
                <div class="input_list">
                  <div class="flex is_between">
                    <?php echo $busyo; ?>
                  </div>
                </div>
              </div>

              <div class="list flex is_between">
                <label for="your_busyo">担当名</label>
                <div class="input_list">
                  <div class="flex is_between">
                    <?php echo $sei; ?>
                    <?php echo $mei; ?>
                  </div>
                </div>
              </div>

              <div class="list flex is_between">
                <label for="tel">電話番号</label>
                <div class="input_list">
                  <div class="flex is_between">
                    <?php echo $tel; ?>
                  </div>
                </div>
              </div>

              <div class="list flex is_between">
                <label for="email">メールアドレス</label>
                <div class="input_list">
                  <div class="flex is_between">
                    <?php echo $email; ?>
                  </div>
                </div>
              </div>

              <div class="privacy_check_box">
                <p class="privacy_check_in">プライバシーポリシーに同意する。</p>
              </div>
              <div class="submit_box">
                <form method="post" action="index.php">
                  <div class="btn_in">
                    <input name="back" class="back_btn" type="submit" value="戻る">
                  </div>
                </form>
                <form method="post" action="confirm.php">
                  <input type="hidden" name="your-company" value="<?php echo $company; ?>">
                  <input type="hidden" name="your-busyo" value="<?php echo $busyo; ?>">
                  <input type="hidden" name="your-sei" value="<?php echo $sei; ?>">
                  <input type="hidden" name="your-mei" value="<?php echo $mei; ?>">
                  <input type="hidden" name="your-email" value="<?php echo $email; ?>">
                  <input type="hidden" name="your-tel" value="<?php echo $tel; ?>">
                  <div class="btn_in">
                    <input name="submit" class="submit_btn" type="submit" value="入力内容を送信">
                  </div>
                </form>
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