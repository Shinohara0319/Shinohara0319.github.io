<?php
session_start();
if (
    !isset($_SESSION['contact_flg']) ||
    (isset($_SESSION['contact_flg']) && $_SESSION['contact_flg'] !== 1)
) {
    // 正規の遷移でない場合コンタクト画面に強制移動
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.html");
    exit;
}
if (isset($_POST) && count($_POST) > 0) {
    // フォームのボタンが押されたら
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // フォームから送信されたデータを各変数に格納
        $company       = isset($_POST['your-company']) ? $_POST['your-company'] : NULL;
        $busyo       = isset($_POST['your-busyo']) ? $_POST['your-busyo'] : NULL;
        $sei       = isset($_POST['your-sei']) ? $_POST['your-sei'] : NULL;
        $mei       = isset($_POST['your-mei']) ? $_POST['your-mei'] : NULL;
        $email      = isset($_POST['your-email']) ? $_POST['your-email'] : NULL;
        $tel       = isset($_POST['your-tel']) ? $_POST['your-tel'] : NULL;

        //POSTされたデータをセッション変数に保存
        $_SESSION['your-company']       = $company;
        $_SESSION['your-busyo']       = $busyo;
        $_SESSION['your-sei']       = $sei;
        $_SESSION['your-mei']       = $mei;
        $_SESSION['your-email']      = $email;
        $_SESSION['your-tel']      = $tel;

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
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/complete.php");
                exit;
            } else {
                $_SESSION['contact'] = $_POST;
                unset($_POST);
                header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.html");
                exit();
            }
        }
    } else {
        // POST遷移でない場合Sessionとクッキーを破棄してコンタクト画面に強制移動
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- <meta charset="UTF-8">
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width-device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>入力内容のご確認 Medical Support</title>
    <meta name="description" content="入力内容のご確認 Medical Support" />
    <meta name="keywords" content="健診代行ならメイサービス Medical Support" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:700&display=swap&subset=japanese" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="./assets/css/confirm.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>


<body id="body">
    <div id="wrapper">
        <header id="header">
            <div class="header__items flex is-between">
                <div class="header__left flex">
                    <div class="header__logo"></div>
                </div>
                <div class="header__right flex sp-only">
                    <a href="https://google.com" target="_blank" class="download__document">
                    </a>
                    <a href="https://google.com" target="_blank" class="estimate__link"></a>
                </div>
            </div>
        </header>
        <main>
            <section id="confirm">
                <div class="form">
                    <div class="form__header">
                        <p class="category">DOWNLOAD</p>
                        <h2>入力内容のご確認</h2>
                    </div>
                    <div class="confirm__form-box">

                        <div class="common_contact contact_confirm">
                            <div class="inner_min">
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

                                    <div class="margin"></div>

                                    <div class="privacy_check_box">
                                        <p class="privacy_check_in"><span>個人情報保護方針</span>に同意する。</p>
                                    </div>
                                    <div class="privacy_check_box">
                                        <p class="privacy_check_in"><span>個人情報の保護に関する弊社の取り扱い</span>に同意する。</p>
                                    </div>
                                    <div class="submit_box">
                                        <form method="post" action="shiryou.php">
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
                </div>
            </section>
        </main>

        <footer>
            <div id="footer" class="footer">
                <div class="footer__content-box flex is-center top-only">
                    <div class="footer__address">
                        COPYRIGHT(C) MEISERVICE co.,ltd ALL RIGHTS RESERVED.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>