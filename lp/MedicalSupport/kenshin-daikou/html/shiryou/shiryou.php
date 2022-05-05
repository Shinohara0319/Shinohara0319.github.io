<?php
session_start();
$_SESSION['contact_flg'] = 1;

//確認から戻っていたら変数にSessionから値を代入
$company       = isset($_SESSION['your-company']) ? $_SESSION['your-company'] : NULL;
$busyo       = isset($_SESSION['your-busyo']) ? $_SESSION['your-busyo'] : NULL;
$sei       = isset($_SESSION['your-sei']) ? $_SESSION['your-sei'] : NULL;
$mei       = isset($_SESSION['your-mei']) ? $_SESSION['your-mei'] : NULL;
$email      = isset($_SESSION['your-email']) ? $_SESSION['your-email'] : NULL;
$tel       = isset($_SESSION['your-tel']) ? $_SESSION['your-tel'] : NULL;
$agree1      = isset($_SESSION['agree1']) ? $_SESSION['agree1'] : NULL;
$agree2      = isset($_SESSION['agree2']) ? $_SESSION['agree2'] : NULL;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width-device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>資料ダウンロードはこちらから Medical Support</title>
    <meta name="description" content="資料ダウンロードはこちらから Medical Support" />
    <meta name="keywords" content="健診代行ならメイサービス Medical Support" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:700&display=swap&subset=japanese" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="http://fonts.cdnfonts.com/css/gotham" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" />
    <link rel="stylesheet" href="../../assets/css/shiryou.css" />
    <link rel="stylesheet" href="../../assets/css/shiryou-form.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="../../assets/js/validation.js"></script>
</head>

<body id="body">
    <div id="wrapper">
        <header id="header">
            <div class="header__items flex is-between">
                <div class="header__left flex">
                    <div class="header__logo"></div>
                </div>
                <div class="header__right flex sp-only">
                    <a href="../shiryou/shiryou.php#shiryou" target="_top" class="download__document">
                    </a>
                    <a href="../../index.php#estimate" target="_top" class="estimate__link"></a>
                </div>
            </div>
        </header>

        <main>
            <section id="shiryou">
                <div class="form">
                    <div class="form__header">
                        <p class="category">DOWNLOAD</p>
                        <h2>資料ダウンロードはこちらから</h2>
                    </div>
                    <div class="shiryou__form-box">
                        <p>入力必須事項</p>
                        <form method="post" name="form" id="form" action="../confirm/shiryou-confirm.php">
                            <div class="contact_box">

                                <div class="list flex is_between">
                                    <label for="your-company">会社名
                                        <p class="mand"><span>*</span></p>
                                    </label>
                                    <div class="input_list">
                                        <div class="flex is_between">
                                            <input type="text" id="your-company" name="your-company" placeholder="株式会社メイサービス（MEISERVICE CO.,LTD）" class="form_input_yourcompany input-your_company required" value="<?php echo $company; ?>" required>
                                        </div>
                                        <div class="validation_space is-valid-company"></div>
                                    </div>
                                </div>

                                <div class="list flex is_between">
                                    <label for="your-busyo">部署名</label>
                                    <div class="input_list">
                                        <div class="flex is_between">
                                            <input type="text" id="your-busyo" name="your-busyo" placeholder="人事部　部長" class="form_input_yourbusyo input-your_busyo required" value="<?php echo $busyo; ?>">
                                        </div>
                                        <div class="validation_space is-valid-busyo"></div>
                                    </div>
                                </div>

                                <div class="list flex is_between">
                                    <label for="your-name">担当名
                                        <p class="mand"><span>*</span></p>
                                    </label>
                                    <div class="input_list">
                                        <div class="flex is_between">
                                            <input type="text" id="your-sei" name="your-sei" placeholder="姓" class="form_input_yoursei input-your_sei required" value="<?php echo $sei; ?>" required>
                                            <input type="text" id="your-mei" name="your-mei" placeholder="名" class="form_input_yourmei input-your_mei required" value="<?php echo $mei; ?>" required>
                                        </div>
                                        <div class="validation_space is-valid-name"></div>
                                    </div>
                                </div>

                                <div class="list flex is_between">
                                    <label for="your-tel">電話番号
                                        <p class="mand"><span>*</span></p>
                                    </label>
                                    <div class="input_list">
                                        <div class="flex is_between">
                                            <input type="tel" id="your-tel" name="your-tel" placeholder="0466287255" class="form_input_tel input-mail required" value="<?php echo $tel; ?>" required>
                                        </div>
                                        <div class="validation_space is-valid-tel"></div>
                                    </div>
                                </div>

                                <div class="list flex is_between">
                                    <label for="your-email">メールアドレス
                                        <p class="mand"><span>*</span></p>
                                    </label>
                                    <div class="input_list">
                                        <div class="flex is_between">
                                            <input type="email" id="your-email" name="your-email" placeholder="example@example.jp" class="form_input_email input-mail required" value="<?php echo $email; ?>" required>
                                        </div>
                                        <div class="validation_space is-valid-email"></div>
                                    </div>
                                </div>

                                <div class="margin"></div>

                                <div id="privacy_check_box" class="privacy_check_box">
                                    <p class="privacy_check_in">
                                        <input type="checkbox" id="agree1" name="agree1" class="privacy_checkbox required" <?php if ($agree1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                        <label for="agree1" class="privacy_txt">
                                            <a class="txt_link" target="_blank" href="https://www.meiservice.com/privacy-policy">個人情報保護方針</a>に同意する
                                        </label>
                                    </p>
                                    <div class="validation_space is-valid-agree1"></div>
                                </div>
                                <div id="privacy_check_box" class="privacy_check_box">
                                    <p class="privacy_check_in">
                                        <input type="checkbox" id="agree2" name="agree2" class="privacy_checkbox required" <?php if ($agree2) {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                                        <label for="agree2" class="privacy_txt">
                                            <a class="txt_link" target="_blank" href="https://www.meiservice.com/privacy-policytreatment">個人情報の保護に関する弊社の取り扱い</a>に同意する
                                        </label>
                                    </p>
                                    <div class="validation_space is-valid-agree2"></div>
                                </div>
                            </div>
                            <div class="submit_box">
                                <div class="btn_in">
                                    <input id="confirm" name="confirm" class="submit_btn" type="submit" value="資料ダウンロードする">
                                </div>
                            </div>
                        </form>
                    </div>
                    <br class="pc-only" />
                    <a href="../../index.php" target="_top" class="return-to-top pc-only">トップに戻る</a>
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