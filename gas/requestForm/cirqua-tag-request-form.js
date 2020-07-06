//チャットワークのトークン
var CHATWORK_TOKEN = '56f3b3822a8220455d15457482741ec1';
var room_id = 62922847; //タスク通知を流したい部屋のrid****の数値のみ記述。
var account_id = 2400224; //Maverickさんのaidを設定してる。
var request_account_id = 4142438;; //酒井さんのaidを設定してる。

function createTaskId() {
  // 生成する文字列の長さ
  var len = 10;

  // 生成する文字列に含める文字セット
  var c = "abcdefghijklmnopqrstuvwxyz0123456789";

  var cl = c.length;
  var id = "";
  for(var i=0; i<len; i++) {
    id += c[Math.floor(Math.random()*cl)];
  }
  return id;
}

function sendReport(e) {
  //フォームの質問内容と一致させて回答を取得してる。
  var taskId = createTaskId();
  var name = e.namedValues['依頼者名'];
  var limit = e.namedValues['納期'];
  var limitReason = e.namedValues['納期理由'];
  var profit = e.namedValues['収益見込み'];
  var moniter = e.namedValues['配信画面'];
  var otherMoniter = e.namedValues['依頼内容'];
  var copy = e.namedValues['コピー？'].filter(function(e) {return e != ''});
  var createStatus = e.namedValues['タグ作成依頼'].filter(function(e) {return e != ''});
  var cirquaUrl = e.namedValues['Cirquaメディア詳細URL'].filter(function(e) {return e != ''});
  var media = e.namedValues['メディア名'].filter(function(e) {return e != ''});
  var count = e.namedValues['依頼枠数'].filter(function(e) {return e != ''});
  var positionUrl = e.namedValues['掲載位置URL'].filter(function(e) {return e != ''});
  var uid = e.namedValues['Cirqua広告枠UID'].filter(function(e) {return e != ''});
  var uidFromPassback = e.namedValues['パスバック埋め込み先UID'].filter(function(e) {return e != ''});
  var copyMedia = e.namedValues['コピー元メディア名'].filter(function(e) {return e != ''});
  var copyUid = e.namedValues['コピー元UID'].filter(function(e) {return e != ''});
  var requestDetails = e.namedValues['依頼内容詳細'].filter(function(e) {return e != ''});
  var design = e.namedValues['デザイン'].filter(function(e) {return e != ''});
  var prNotation = e.namedValues['PR表記'].filter(function(e) {return e != ''});
  var prCharacter = e.namedValues['PRの文言を指定してください。'].filter(function(e) {return e != ''});
  var prPosition = e.namedValues['PRの設置位置を指定してください。'].filter(function(e) {return e != ''});
  var prDesign = e.namedValues['PRのデザインを指定してください。'].filter(function(e) {return e != ''});
  var prNone = e.namedValues['上長の許可なくPRを「無し」にはできません。許可を得ましたか？'].filter(function(e) {return e != ''});
  var prPolicy = e.namedValues['プライバシーポリシー（通称iマーク）の遷移先をどうするか記入してください。'].filter(function(e) {return e != ''});
  var advertiserNotation = e.namedValues['主体者名表記'].filter(function(e) {return e != ''});
  var advertiserPosition = e.namedValues['主体者名の設置位置を指定してください。'].filter(function(e) {return e != ''});
  var advertiserDesign = e.namedValues['主体者名のデザインを指定してください。'].filter(function(e) {return e != ''});
  var iframe = e.namedValues['iframe・バスターコールの有無を指定してください。'].filter(function(e) {return e != ''});
  var image = e.namedValues['参考にするデザイン、埋め込み先の画像を入稿してください。'].filter(function(e) {return e != ''});
  var headerTitle = e.namedValues['ヘッダータイトル(帯)の有無を指定してください。'].filter(function(e) {return e != ''});
  var headerTitleDesign = e.namedValues['ヘッダータイトル(帯)のデザインを指定してください。'].filter(function(e) {return e != ''});

  //納期をチャットワークの期限にできるよう加工してる。
  var date = (""+limit).match(/^(\d+)\/(\d+)\/(\d+)$/);
  var fixLimitFormat = new Date(date[1], Number(date[2])-1, date[3]);
  var limitDate = fixLimitFormat.getTime()/1000;
  limitDate = limitDate.toFixed();


  function prAdvertiserCheck() {
    if (prNotation == '有') {
      message += '　 └　PR有無: ■' + prNotation + '\n';
      message += '　 └　PR文言: ' + prCharacter + '\n';
      message += '　 └　PR 設置位置: ' + prPosition + '\n';
      message += '　 └　PR デザイン: ' + prDesign + '\n';
    } else if (prNotation == '無') {
      message += '　 └　PR有無: ' + prNotation + '\n';
      if (prNone == 'はい') {
        message += '　 └　上司確認済み: ■' + prNone + '\n';
        message += '　 └　プライバシーポリシーをどうするか: ' + prPolicy + '\n';
      }
    } else if (prNotation == '作成担当者におまかせ') {
      message += '　 └　PR有無: ■' + prNotation + '\n';
    }
    if (advertiserNotation == '有') {
      message += '　 └　主体者名有無: ■' + advertiserNotation + '\n';
      message += '　 └　主体者名 設置位置: ' + advertiserPosition + '\n';
      message += '　 └　主体者名 デザイン: ' + advertiserDesign + '\n';
    } else if (advertiserNotation == '無' || advertiserNotation == '作成担当者におまかせ') {
      message += '　 └　主体者名有無: ■' + advertiserNotation + '\n';
    }
  }

  var message = '';
  message =  '依頼者名: '+name+'\n'; //見やすくするために改行いれます
  message += '納期: ' + limit + '\n';
  message += 'タスクID: ' + taskId + '\n';
  if (limitReason != '') { message += '理由: ' + limitReason + '\n'; }
  if (profit != '') { message += '収益見込み: ' + profit + '\n'; }
  if (moniter == 'Web') {
    message += '******************************\n';
    message += '[基本情報]\n';
    message += '作成内容: ■' + createStatus + '\n';
    message += '配信先: ■' + moniter + '\n';
    message += 'メディア名: ' + media + '\n';
    message += 'Cirquaメディア詳細URL: ' + cirquaUrl + '\n';
    message += '******************************\n';
    message += '[依頼内容]\n';
    if (count != '') { message += '・依頼広告枠数: ' + count + '枠\n\n'; }

    //Web・新規作成パターン
    if (createStatus == '新規') {
      if (copy == 'コピー+UID変更で良い。') {
        message += '掲載位置URL: ' + positionUrl + '\n';
        message += 'Cirqua広告枠UID: ' + uid + '\n';
        message += 'コピー元メディア名: ' + copyMedia + '\n';
        message += 'コピー元UID: ' + copyUid + '\n\n';
        if (headerTitle == '有') {
          message += '・ヘッダータイトル: 有\n' + '　 └　デザイン: ' + headerTitleDesign + '\n\n';
        }
      } else if (copy == '別デザインで作成') {
        message += '・依頼内容詳細\n' + requestDetails + '\n\n';
        if (headerTitle == '有') {
          message += '・ヘッダータイトル: 有\n' + '　 └　デザイン: ' + headerTitleDesign + '\n\n';
        }
        if (design != '') { message += '・デザイン\n' + design + '\n'; }
        prAdvertiserCheck();
      }
    //Web・増枠パターン
    } else if (createStatus == '増枠') {
      //コピーのみ
      if (copy == 'コピー+UID変更で良い。') {
        message += 'Cirqua広告枠UID: ' + uid + '\n';
        message += 'コピー元メディア名: ' + copyMedia + '\n';
        message += 'コピー元UID: ' + copyUid + '\n\n';
        if (headerTitle == '有') {
          message += '・ヘッダータイトル: 有\n' + '　 └　デザイン: ' + headerTitleDesign + '\n\n';
        }
      //新規デザイン
      } else if (copy == '別デザインで作成') {
        message += '・依頼内容詳細\n' + requestDetails + '\n\n';
        if (headerTitle == '有') {
          message += '・ヘッダータイトル: 有\n' + '　 └　デザイン: ' + headerTitleDesign + '\n\n';
        }
        if (design != '') { message += '・デザイン\n' + design + '\n'; }
        prAdvertiserCheck();
      }
    } else if (createStatus == '修正') {
      message += '・依頼内容詳細\n' + requestDetails + '\n\n';
    }
  //アプリ
  } else if (moniter == 'アプリ') {
    message += '******************************\n';
    message += '[基本情報]\n';
    message += '作成内容: ■' + createStatus + '\n';
    message += '配信先: ■' + moniter + '\n';
    message += 'メディア名: ' + media + '\n';
    message += 'Cirquaメディア詳細URL: ' + cirquaUrl + '\n';
    message += '******************************\n';
    message += '[依頼内容]\n';
    if (createStatus == '新規') {
      if (copy == 'コピー+UID変更で良い。') {
        message += 'Cirqua広告枠UID: ' + uid + '\n';
        message += 'コピー元メディア名: ' + copyMedia + '\n';
        message += 'コピー元UID: ' + copyUid + '\n\n';
        if (headerTitle == '有') {
          message += '・ヘッダータイトル: 有\n' + '　 └　デザイン: ' + headerTitleDesign + '\n\n';
        }
      } else if (copy == '別デザインで作成') {
        message += '・依頼内容詳細\n' + requestDetails + '\n\n';
        if (headerTitle == '有') {
          message += '・ヘッダータイトル: 有\n' + '　 └　デザイン: ' + headerTitleDesign + '\n\n';
        }
        if (design != '') { message += '・デザイン\n' + design + '\n'; }
        prAdvertiserCheck();
      }
    //アプリ・増枠パターン
    } else if (createStatus == '増枠') {
      //コピーのみ
      if (copy == 'コピー+UID変更で良い。') {
        message += 'Cirqua広告枠UID: ' + uid + '\n';
        message += 'コピー元メディア名: ' + copyMedia + '\n';
        message += 'コピー元UID: ' + copyUid + '\n\n';
        if (headerTitle == '有') {
          message += '・ヘッダータイトル: 有\n' + '　 └　デザイン: ' + headerTitleDesign + '\n\n';
        }
      } else if (copy == '別デザインで作成') {
        message += '・依頼内容詳細\n' + requestDetails + '\n\n';
        if (headerTitle == '有') {
          message += '・ヘッダータイトル: 有\n' + '　 └　デザイン: ' + headerTitleDesign + '\n\n';
        }
        if (design != '') { message += '・デザイン\n' + design + '\n'; }
        prAdvertiserCheck();
      }
    } else if (createStatus == '修正') {
      message += '・依頼内容詳細\n' + requestDetails + '\n\n';
    }

  //パスバック
  } else if (moniter == 'パスバック') {
    message += '******************************\n';
    message += '[基本情報]\n';
    message += '作成内容: ■' + createStatus + '\n';
    message += '配信先: ■' + moniter + '\n';
    message += 'メディア名: ' + media + '\n';
    message += 'Cirquaメディア詳細URL: ' + cirquaUrl + '\n';
    message += '******************************\n';
    message += '[依頼内容]\n';
    if (createStatus == '新規') {
      if (copy == 'コピー+UID変更で良い。') {
        message += '掲載位置URL: ' + positionUrl + '\n';
        message += 'Cirqua広告枠UID: ' + uid + '\n';
        message += 'パスバック埋め込み先UID: ' + uidFromPassback + '\n';
        message += 'コピー元メディア名: ' + copyMedia + '\n';
        message += 'コピー元UID: ' + copyUid + '\n\n';
      } else if (copy == '別デザインで作成') {
        message += '・依頼内容詳細\n' + requestDetails + '\n\n';
        if (design != '') { message += '・デザイン\n' + design + '\n'; }
        prAdvertiserCheck();
      }
    } else if (createStatus == '増枠') {
      if (copy == 'コピー+UID変更で良い。') {
        message += 'Cirqua広告枠UID: ' + uid + '\n';
        message += 'コピー元メディア名: ' + copyMedia + '\n';
        message += 'コピー元UID: ' + copyUid + '\n\n';
      } else if (copy == '別デザインで作成') {
        message += '・依頼内容詳細\n' + requestDetails + '\n\n';
        if (design != '') { message += '・デザイン\n' + design + '\n'; }
        prAdvertiserCheck();
      }
    } else if (createStatus == '修正') {
      message += '・依頼内容詳細\n' + requestDetails + '\n\n';
    }
  } else if (moniter == 'Cirqua内パスバック') {
    message += '******************************\n';
    message += '[基本情報]\n';
    message += '作成内容: ■' + createStatus + '\n';
    message += '配信先: ■' + moniter + '\n';
    message += 'メディア名: ' + media + '\n';
    message += 'Cirquaメディア詳細URL: ' + cirquaUrl + '\n';
    message += '******************************\n';
    if (createStatus == '新規') {
      if (copy == 'コピー+UID変更で良い。') {
        message += '掲載位置URL: ' + positionUrl + '\n';
        message += 'Cirqua広告枠UID: ' + uid + '\n';
        message += 'パスバック埋め込み先UID' + uidFromPassback + '\n';
        message += 'コピー元メディア名: ' + copyMedia + '\n';
        message += 'コピー元UID: ' + copyUid + '\n\n';
      } else if (copy == '別デザインで作成') {
        message += '・依頼内容詳細\n' + requestDetails + '\n\n';
        if (design != '') { message += '・デザイン\n' + design + '\n'; }
        prAdvertiserCheck();
      }
    } else if (createStatus == '増枠') {
      if (copy == 'コピー+UID変更で良い。') {
        message += 'Cirqua広告枠UID: ' + uid + '\n';
        message += 'コピー元メディア名: ' + copyMedia + '\n';
        message += 'コピー元UID: ' + copyUid + '\n\n';
      } else if (copy == '別デザインで作成') {
        message += '・依頼内容詳細\n' + requestDetails + '\n\n';
        if (design != '') { message += '・デザイン\n' + design + '\n'; }
        prAdvertiserCheck();
      }
    } else if (createStatus == '修正') {
      message += '・依頼内容詳細\n' + requestDetails + '\n\n';
    }
  }
  message += '******************************\n';
  message += '[システム情報]\n';
  message += '・iframe: ■' + iframe + '\n';
  message += '******************************\n';
  message += image.toString().replace(/, /g, '\n');

  //その他はフッターにシステム情報つけたくないので、messageの中を一度空にして追加する。
  if (moniter == 'その他') {
    message = '';
    message += '依頼者名: ' + name + '\n'; //見やすくするために改行いれます。
    message += 'タスクID: ' + taskId + '\n';
    message += '依頼内容' + otherMoniter + '\n';
    message += image.toString().replace(/, /g, '\n');
  }

  var params = {
    headers: {"X-ChatWorkToken" : CHATWORK_TOKEN},
    method: "post",
    payload: {
      body: message,
      limit: limitDate,
      to_ids: request_account_id
    }
  };

  var url = "https://api.chatwork.com/v2/rooms/" + room_id + "/tasks";
  UrlFetchApp.fetch(url, params);
}
