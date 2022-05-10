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
    <link rel="stylesheet" href="/assets/css/common.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body>
    <div class="wrap">
        <header class="header sub">
            <h1>サンクスページ</h1>
        </header>
        <footer>
            <div class="footer_btm">
                <p class="copy">Copyright All Rights Reserved.</p>
            </div>
        </footer>
    </div>
</body>

</html>