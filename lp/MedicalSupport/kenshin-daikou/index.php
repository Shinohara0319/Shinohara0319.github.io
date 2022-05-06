<?php
session_start();
$_SESSION['contact_flg'] = 1;

//確認から戻っていたら変数にSessionから値を代入
$company       = isset($_SESSION['your-company']) ? $_SESSION['your-company'] : NULL;
$staffNumber       = isset($_SESSION['your-staffNumber']) ? $_SESSION['your-staffNumber'] : NULL;
$sei       = isset($_SESSION['your-sei']) ? $_SESSION['your-sei'] : NULL;
$mei       = isset($_SESSION['your-mei']) ? $_SESSION['your-mei'] : NULL;
$email      = isset($_SESSION['your-email']) ? $_SESSION['your-email'] : NULL;
$tel       = isset($_SESSION['your-tel']) ? $_SESSION['your-tel'] : NULL;
$agree1      = isset($_SESSION['agree1']) ? $_SESSION['agree1'] : NULL;
$agree2      = isset($_SESSION['agree2']) ? $_SESSION['agree2'] : NULL;

if (
  !isset($_SESSION['contact_flg']) ||
  (isset($_SESSION['contact_flg']) && $_SESSION['contact_flg'] !== 1)
) {
  // 正規の遷移でない場合コンタクト画面に強制移動
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/kenshin-daikou/index.php");
  exit;
}
if (isset($_POST) && count($_POST) > 0) {
  // フォームのボタンが押されたら
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // フォームから送信されたデータを各変数に格納
    $company       = isset($_POST['your-company']) ? $_POST['your-company'] : NULL;
    $staffNumber       = isset($_POST['your-staffNumber']) ? $_POST['your-staffNumber'] : NULL;
    $sei       = isset($_POST['your-sei']) ? $_POST['your-sei'] : NULL;
    $mei       = isset($_POST['your-mei']) ? $_POST['your-mei'] : NULL;
    $email      = isset($_POST['your-email']) ? $_POST['your-email'] : NULL;
    $tel       = isset($_POST['your-tel']) ? $_POST['your-tel'] : NULL;

    switch ($staffNumber) {
      case '1':
        $staffNumber = "50人未満";
        break;
      case '2':
        $staffNumber = "50人以上〜100人未満";
        break;
      case '3':
        $staffNumber = "100人以上〜300人未満";
        break;
      case '4':
        $staffNumber = "300人以上";
        break;
      default:
        $staffNumber = "---";
    }

    //POSTされたデータをセッション変数に保存
    $_SESSION['your-company']       = $company;
    $_SESSION['your-staffNumber']       = $staffNumber;
    $_SESSION['your-sei']       = $sei;
    $_SESSION['your-mei']       = $mei;
    $_SESSION['your-email']      = $email;
    $_SESSION['your-tel']      = $tel;

    // 送信ボタンが押されたら
    if (isset($_POST["submit"])) {
      //メール送信処理
      require_once './libs/SendEmail.php';
      //メール送信処理
      $mail = new SendEmail;
      $sendAdmin = $mail->sendContactToAdmin($_POST);
      $sendUser  = $mail->sendContactToUser($_POST);
      if ($sendAdmin && $sendUser) {
        //終了処理
        unset($_POST);
        $_SESSION['contact_flg'] = 2;
        // サンクスページに画面遷移させる
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/kenshin-daikou/thanks/index.php");
        exit;
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width-device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>健診代行ならメイサービス Medical Support</title>
  <meta name="description" content="健診代行ならメイサービス Medical Support" />
  <meta name="keywords" content="健診代行ならメイサービス Medical Support" />
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:700&display=swap&subset=japanese" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
  <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/gotham" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" />
  <link rel="stylesheet" href="/kenshin-daikou/assets/css/toppage.css" />
  <link rel="stylesheet" href="/kenshin-daikou/assets/css/estimate-form.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="/kenshin-daikou/assets/js/validation.js"></script>
  <script type="text/javascript" src="/kenshin-daikou/assets/js/onchange.js"></script>
</head>

<body id="body">
  <div id="wrapper">
    <header id="header">
      <div class="header__items flex is-between">
        <div class="header__left flex">
          <div class="header__logo"></div>
        </div>
        <div class="header__right flex">
          <a href="/kenshin-daikou/shiryou/index.php#shiryou" target="_top" class="download__document"></a>
          <a href="#estimate" target="_top" class="estimate__link"></a>
        </div>
      </div>
    </header>

    <main>
      <section id="fv">
        <div class="fv__content-box flex is-center">
          <div class="fv__left">
            <div class="fv__text-box">
              <div class="fv__small-text">
                <p class="fv__first-text">
                  <span class="fv__text">継続率<span class="fv__number">98</span>%</span>の実績！
                </p>
                <p class="fv__second-text">
                  おかげさまでサービス開始から10周年！
                </p>
              </div>
              <div class="fv__big-text">
                <p>リモートで実現、</p>
                <p>業務改善の健診代行なら</p>
              </div>
              <div class="logo">
                <img src="/kenshin-daikou/assets/img/section_fv/Medicalsupport-logo大.png" alt="Medicalsupport-logo" />
              </div>
            </div>
            <div class="fv__research">
              <p>※自社調べ</p>
            </div>
            <a href="/kenshin-daikou/shiryou/index.php#shiryou" target="_top" class="download__document-pc"></a>
          </div>
          <div class="fv__right">
            <img src="/kenshin-daikou/assets/img/section_fv/image1.png" alt="fv__image" />
          </div>
          <a href="/kenshin-daikou/shiryou/index.php#shiryou" target="_top" class="download__document-sp">
          </a>
        </div>
      </section>

      <section id="grid">
        <div class="grid__label flex is-center">
          <div class="grid__monthly_limit">
            <p class="grid__monthly_limit_text">毎月<span>3</span>社限定</p>
          </div>
          <div class="grid__text">
            <p>
              今だけ！<span class="big">初期費用半額</span><span>キャンペーン</span>
            </p>
          </div>
          <div class="grid__cursor"></div>
        </div>
      </section>

      <section id="trouble">
        <p class="category">TROUBLE</p>
        <h2>こんな<span>お悩み</span>や<span>課題</span>はありませんか？</h2>
        <div class="trouble__content-box flex is-center">
          <div>
            <div class="trouble__image">
              <img src="/kenshin-daikou/assets/img/section_trouble/image1.png" alt="trouble__image" />
            </div>
            <div class="trouble__question-box flex-nowrap">
              <div class="trouble__question flex-nowrap is-center is-start">
                <div class="trouble__border sp-only"></div>
                <div class="trouble__question-number">1</div>
                <div class="trouble__question-text">
                  <p>
                    通常業務が繁忙すぎて、<br /><span class="trouble__question-text-bold">健康診断の業務まで手が回らない</span>
                  </p>
                </div>
              </div>
              <div class="trouble__border pc-only"></div>
              <div class="trouble__question flex-nowrap is-center is-start">
                <div class="trouble__border sp-only"></div>
                <div class="trouble__question-number">2</div>
                <div class="trouble__question-text">
                  <p>
                    健診計画と受診対象者の<br /><span class="trouble__question-text-bold">スケジュール調整に時間がかかり大変</span>
                  </p>
                </div>
              </div>
              <div class="trouble__border pc-only"></div>
              <div class="trouble__question flex-nowrap is-center is-start">
                <div class="trouble__border sp-only"></div>
                <div class="trouble__question-number">3</div>
                <div class="trouble__question-text">
                  <p class="trouble__question-text-bold">
                    なかなか受信率が上がらない
                  </p>
                </div>
              </div>
            </div>
            <div class="trouble__question-box flex-nowrap">
              <div class="trouble__question flex-nowrap is-center is-start">
                <div class="trouble__border sp-only"></div>
                <div class="trouble__question-number">4</div>
                <div class="trouble__question-text">
                  <p>
                    受診者の健診予約、変更、<br class="sp-only" />キャンセル等の<br class="pc-only" /><span class="trouble__question-text-bold">調整業務の負荷が多い</span>
                  </p>
                </div>
              </div>
              <div class="trouble__border pc-only"></div>
              <div class="trouble__question flex-nowrap is-center is-start">
                <div class="trouble__border sp-only"></div>
                <div class="trouble__question-number">5</div>
                <div class="trouble__question-text">
                  <p>
                    いくつもの医療機関で<br class="sp-only" />健診しているため、<br class="sp-only" /><span class="trouble__question-text-bold">請求が分かれ処理に手間がかかる</span>
                  </p>
                </div>
              </div>
              <div class="trouble__border pc-only"></div>
              <div class="trouble__question pc-only" style="opacity: 0"></div>
            </div>
            <div class="trouble__down-cursor"></div>
            <p class="trouble__text">
              健康診断業務は<br class="sp-only" />メディカルサポートにお任せください
            </p>
            <a href="/kenshin-daikou/shiryou/index.php#shiryou" target="_top" class="download__document">
              <img src="/kenshin-daikou/assets/img/section_trouble/document__download.png" alt="download__document" />
            </a>
          </div>
        </div>
      </section>

      <section id="realizable">
        <p class="category">REALIZABLE</p>
        <h2>メディカルサポートで<span>実現できること</span></h2>
        <div class="realizable__content-box flex is-center">
          <div>
            <div class="realizable__content flex">
              <div class="realizable__content-text-box first flex is-center sp-only">
                <div class="realizable__content-icon">
                  <img src="/kenshin-daikou/assets/img/section_realizable/checking_icon.svg" alt="realizable__checking_icon" />
                </div>
                <div class="realizable__content-text flex is-center">
                  <p>
                    これまでの健診業務を<br /><span>約<span class="realizable__content-text-big">80%</span>軽減</span>できます
                  </p>
                </div>
              </div>
              <div class="realizable__content-image flex is-center">
                <img src="/kenshin-daikou/assets/img/section_realizable/image1.png" alt="section_realizable/image1.png" />
              </div>
              <div class="realizable__content-text-box first flex is-center pc-only">
                <div class="realizable__content-icon">
                  <img src="/kenshin-daikou/assets/img/section_realizable/checking_icon.svg" alt="realizable__checking_icon" />
                </div>
                <div class="realizable__content-text flex is-center">
                  <p>
                    これまでの健診業務を<br /><span>約<span class="realizable__content-text-big">80%</span>軽減</span>できます
                  </p>
                </div>
              </div>
            </div>
            <div class="realizable__border"></div>
            <div class="realizable__content flex">
              <div class="realizable__content-text-box second flex is-center">
                <div class="realizable__content-icon">
                  <img src="/kenshin-daikou/assets/img/section_realizable/checking_icon.svg" alt="realizable__checking_icon" />
                </div>
                <div class="realizable__content-text flex is-center">
                  <p>
                    <span><span class="realizable__content-text-big">全国</span>に</span>提携医療機関<br />受診者の利便性にお応えします
                  </p>
                </div>
              </div>
              <div class="realizable__content-image flex is-center">
                <img src="/kenshin-daikou/assets/img/section_realizable/image2.png" alt="section_realizable/image2.png" />
              </div>
            </div>
            <div class="realizable__border"></div>
            <div class="realizable__content flex">
              <div class="realizable__content-text-box third flex is-center sp-only">
                <div class="realizable__content-icon">
                  <img src="/kenshin-daikou/assets/img/section_realizable/checking_icon.svg" alt="realizable__checking_icon" />
                </div>
                <div class="realizable__content-text flex is-center">
                  <p>
                    <span>受診率<span class="realizable__content-text-big">100%</span></span>を共通目標に<br />しっかりサポートいたします
                  </p>
                </div>
              </div>
              <div class="realizable__content-image flex is-center">
                <img src="/kenshin-daikou/assets/img/section_realizable/image3.png" alt="section_realizable/image3.png" />
              </div>
              <div class="realizable__content-text-box third flex is-center pc-only">
                <div class="realizable__content-icon">
                  <img src="/kenshin-daikou/assets/img/section_realizable/checking_icon.svg" alt="realizable__checking_icon" />
                </div>
                <div class="realizable__content-text flex is-center">
                  <p>
                    <span>受診率<span class="realizable__content-text-big">100%</span></span>を共通目標に<br />しっかりサポートいたします
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="service">
        <p class="category">SERVICE</p>
        <h2>サービス紹介</h2>
        <div class="service__content-box flex is-center">
          <div class="service__content flex is-center">
            <div class="service__number-box">
              <p class="service__number-text">SERVICE</p>
              <p class="service__number">01</p>
            </div>
            <div class="service__image">
              <img src="/kenshin-daikou/assets/img/section_service/image1.png" alt="service__image1" />
            </div>
            <div class="service__text-box">
              <h3>健診に関わる業務をお引き受けします</h3>
              <p>お客様の環境にあったアウトソーシングにも対応します。</p>
              <p>定期健診以外の健診の外注をお願いしたい</p>
              <p>
                予約ツール（PC/アプリ）の利用環境の無い従業員さまのための電話予約
              </p>
              <p>健診結果をデータ化して管理したい</p>
            </div>
          </div>
        </div>
        <div class="service__content-box flex is-center">
          <div class="service__content flex is-center">
            <div class="service__number-box">
              <p class="service__number-text">SERVICE</p>
              <p class="service__number">02</p>
            </div>
            <div class="service__image">
              <img src="/kenshin-daikou/assets/img/section_service/image2.png" alt="service__image2" />
            </div>
            <div class="service__text-box">
              <h3>
                <span class="flex">全国の医療機関に対応</span>
                <span class="flex">全国に拠点のある企業にお応えします</span>
              </h3>
              <p>
                管理者の方には、予約や受診状況が一目でわかる管理ツールをご提供
              </p>
              <p>受診者の方には、簡単に健診予約が出来るツールをご提供</p>
              <p>
                受診忘れ防止のための「お知らせメール配信サービス」もご用意
              </p>
            </div>
          </div>
        </div>
        <div class="service__content-box flex is-center">
          <div class="service__content flex is-center">
            <div class="service__number-box">
              <p class="service__number-text">SERVICE</p>
              <p class="service__number">03</p>
            </div>
            <div class="service__image">
              <img src="/kenshin-daikou/assets/img/section_service/image3.png" alt="service__image3" />
            </div>
            <div class="service__text-box">
              <h3>
                <span class="flex">健診費用は、一括精算をご提供</span>
                <span class="flex">それぞれ面倒な精算がなくなります</span>
              </h3>
              <p>各医療機関からの請求を取り纏めて、一括精算が可能</p>
              <p>健診結果（事業者控え）を取り纏めて、ご請求明細とお届け</p>
            </div>
          </div>
        </div>
        <a href="/kenshin-daikou/shiryou/index.php#shiryou" target="_top" class="download__document">
          <img src="/kenshin-daikou/assets/img/section_service/document_download.png" alt="download__document" />
        </a>
      </section>

      <section id="point">
        <p class="category">POINT</p>
        <h2>メディカルサポートの<span>ここがすごい！</span></h2>
        <div class="point__content-box flex is-center">
          <div>
            <div class="point__content first flex is-center">
              <div class="point__image">
                <img src="/kenshin-daikou/assets/img/section_point/image1.png" alt="point__image1" />
              </div>
              <div class="point__image">
                <img src="/kenshin-daikou/assets/img/section_point/image2.png" alt="point__image2" />
              </div>
              <div class="point__image">
                <img src="/kenshin-daikou/assets/img/section_point/image3.png" alt="point__image3" />
              </div>
            </div>
            <div class="point__content second flex is-center">
              <div class="point__image">
                <img src="/kenshin-daikou/assets/img/section_point/image4.png" alt="point__image4" />
              </div>
              <div class="point__image">
                <img src="/kenshin-daikou/assets/img/section_point/image5.png" alt="point__image5" />
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="estimate">
        <p class="category">ESTIMATE</p>
        <h2>お見積はこちら</h2>
        <div class="estimate__content-box flex is-center">
          <div>
            <div class="estimate__description">
              <p>
                入力完了後、内容をご確認いただき、「送信する」ボタンをクリックしてください。
              </p>
              <p>
                ご入力いただいた個人情報は、
                <a href="https://www.meiservice.com/privacy-policy" target="_blank" class="privacy-policy">個人情報保護方針</a>及び<a href="https://www.meiservice.com/privacy-policy/treatment" target="_blank" class="privacy-policy-treatment">個人情報保護に関する弊社の取り扱い</a>基づき、適切な取扱いを行います。
              </p>
            </div>
            <div class="estimate__form-box">
              <p>入力必須事項</p>
              <form method="post" name="form" id="form" action="index.php">
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
                    <label for="your-staffNumber">従業員数
                      <p class="mand"><span>*</span></p>
                    </label>
                    <div class="input_list">
                      <div class="flex is_between">
                        <div class="select-box-cursor"></div>
                        <select onchange="changeItem(this)" style="color: #c8c8c8;" name="your-staffNumber" id="your-staffNumber" class="form_input_yourstaffNumber input-your_staffNumber required" autocapitalize="street-staffNumber required" placeholder="" value="<?php echo $staffNumber; ?>" required>
                          <option value="">---</option>
                          <option value="1" <?php if ($staffNumber === "50人未満") {
                                              echo "selected";
                                            } ?>>50人未満</option>
                          <option value="2" <?php if ($staffNumber === "50人以上〜100人未満") {
                                              echo "selected";
                                            } ?>>50人以上〜100人未満</option>
                          <option value="3" <?php if ($staffNumber === "100人以上〜300人未満") {
                                              echo "selected";
                                            } ?>>100人以上〜300人未満</option>
                          <option value="4" <?php if ($staffNumber === "300人以上") {
                                              echo "selected";
                                            } ?>>300人以上</option>
                        </select>
                      </div>
                      <div class="validation_space is-valid-staffNumber"></div>
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
                        <a class="txt_link" target="_blank" href="https://www.meiservice.com/privacy-policy/treatment">個人情報の保護に関する弊社の取り扱い</a>に同意する
                      </label>
                    </p>
                    <div class="validation_space is-valid-agree2"></div>
                  </div>
                </div>
                <div class="submit_box">
                  <form method="post" action="/kenshin-daikou/thanks/index.php">
                    <input type="hidden" name="your-company" value="<?php echo $company; ?>">
                    <input type="hidden" name="your-staffNumber" value="<?php echo $staffNumber; ?>">
                    <input type="hidden" name="your-sei" value="<?php echo $sei; ?>">
                    <input type="hidden" name="your-mei" value="<?php echo $mei; ?>">
                    <input type="hidden" name="your-email" value="<?php echo $email; ?>">
                    <input type="hidden" name="your-tel" value="<?php echo $tel; ?>">
                    <div class="btn_in">
                      <input id="submit" name="submit" class="submit_btn" type="submit" value="送信する">
                    </div>
                  </form>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>

      <section id="logo">
        <div class="logo__content-box flex is-center">
          <img src="/kenshin-daikou/assets/img/common/logo.png" alt="MedicalSupport logo" />
        </div>
      </section>
    </main>
    <footer>
      <div id="footer" class="footer">
        <div class="footer__content-box flex is-between">
          <div class="footer__privacy-policy-link-box flex is-center">
            <a href="https://www.meiservice.com/privacy-policy" target="_blank" class="privacy-policy">個人情報保護方針</a>
            <a href="https://www.meiservice.com/privacy-policy/treatment" target="_blank" class="privacy-policy-treatment">個人情報保護に関する弊社の取り扱い</a>
          </div>
          <div class="footer__address flex is-center">
            COPYRIGHT(C) MEISERVICE co.,ltd ALL RIGHTS RESERVED.
          </div>
        </div>
      </div>
    </footer>
  </div>
</body>

</html>