<?php
session_start();
$_SESSION['contact_flg'] = 1;

//確認から戻っていたら変数にSessionから値を代入
$company       = isset($_SESSION['your-company']) ? $_SESSION['your-company'] : NULL;
$staffNumber       = isset($_SESSION['your-staffNumber']) ? $_SESSION['your-staffNumber'] : NULL;
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
    <meta charset="UTF-8">
    <title>お問い合わせ</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta name="format-detection" content="telephone=no">
    <!-- <link rel="icon" href="/assets/img/common/favicon.ico"> -->
    <!-- <link rel="icon" type="image/png" href="/assets/img/common/android-chrome-256x256.png"> -->
    <!-- <link rel="apple-touch-icon" href="/assets/img/common/apple-touch-icon.png"> -->
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&display=swap&subset=japanese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@200&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/common.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/validation.js"></script>
</head>

<body>
    <div class="wrap">

        <div class="page_contact">
            <div class="common_contact">
                <div class="inner_min">
                    <h3 class="common_ttl">
                        資料ダウンロードはこちらから
                    </h3>
                    <p class="common_alt"><span>※</span>入力必須事項</p>
                    <form method="post" name="form" id="form" action="/confirm/confirm.php">
                        <div class="contact_box">

                            <div class="list flex is-between">
                                <label for="your-company">会社名
                                    <p class="mand"><span>*</span></p>
                                </label>
                                <div class="input_list">
                                    <div class="flex is-between">
                                        <input type="text" id="your-company" name="your-company" placeholder="株式会社メイサービス" class="form_input_yourcompany input-your_company required" value="<?php echo $company; ?>" required>
                                    </div>
                                    <div class="validation_space is-valid-company"></div>
                                </div>
                            </div>

                            <div class="list flex is-between">
                                <label for="your-staffNumber">従業員数
                                    <p class="mand"><span>*</span></p>
                                </label>
                                <div class="input_list">
                                    <div class="flex is-between">
                                        <select name="your-staffNumber" id="your-staffNumber" class="form_input_yourstaffNumber input-your_staffNumber required" autocapitalize="street-staffNumber" placeholder="" value="<?php echo $staffNumber; ?>" required>>
                                            <option value="">---</option>
                                            <option value="1" <?php if ($staffNumber === "10人以内") {
                                                                    echo "selected";
                                                                } ?>>10人以内</option>
                                            <option value="2" <?php if ($staffNumber === "10人以上50人以下") {
                                                                    echo "selected";
                                                                } ?>>10人以上50人以下</option>
                                            <option value="3" <?php if ($staffNumber === "50人以上") {
                                                                    echo "selected";
                                                                } ?>>50人以上</option>
                                        </select>
                                    </div>
                                    <div class="validation_space is-valid-staffNumber"></div>
                                </div>
                            </div>

                            <div class="list flex is-between">
                                <label for="your-name">担当名
                                    <p class="mand"><span>*</span></p>
                                </label>
                                <div class="input_list">
                                    <div class="flex is-between">
                                        <input type="text" id="your-sei" name="your-sei" placeholder="山田" class="form_input_yoursei input-your_sei required" value="<?php echo $sei; ?>" required>
                                        <input type="text" id="your-mei" name="your-mei" placeholder="太郎" class="form_input_yourmei input-your_mei required" value="<?php echo $mei; ?>" required>
                                    </div>
                                    <div class="validation_space is-valid-name"></div>
                                </div>
                            </div>

                            <div class="list flex is-between">
                                <label for="your-tel">電話番号
                                    <p class="mand"><span>*</span></p>
                                </label>
                                <div class="input_list">
                                    <div class="flex is-between">
                                        <input type="tel" id="your-tel" name="your-tel" placeholder="0466287255" class="form_input_tel input-mail required" value="<?php echo $tel; ?>" required>
                                    </div>
                                    <div class="validation_space is-valid-tel"></div>
                                </div>
                            </div>

                            <div class="list flex is-between">
                                <label for="your-email">メールアドレス
                                    <p class="mand"><span>*</span></p>
                                </label>
                                <div class="input_list">
                                    <div class="flex is-between">
                                        <input type="email" id="your-email" name="your-email" placeholder="test@test.co.jp" class="form_input_email input-mail required" value="<?php echo $email; ?>" required>
                                    </div>
                                    <div class="validation_space is-valid-email"></div>
                                </div>
                            </div>

                            <div id="privacy_check_box" class="privacy_check_box">
                                <p class="privacy_check_in">
                                    <input type="checkbox" id="agree1" name="agree1" class="privacy_checkbox required" <?php if ($agree1) {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                                    <label for="agree1" class="privacy_txt">
                                        <a class="txt_link" href="../privacypolicy/index.html">個人情報保護方針</a>に同意する
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
                                        <a class="txt_link" href="../privacypolicy/index.html">個人情報の保護に関する弊社の取り扱い</a>に同意する
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