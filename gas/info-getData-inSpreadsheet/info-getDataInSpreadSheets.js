var API_TOKEN = "a1b003618478c1c19e0afb35db339ca6"; //チャットワークAPIトークン
var spreadsheet = SpreadsheetApp.openById(
  "1LdB7bycAlQsyeNQTM3dZpqm09sU5RFk0MBSpWbs0R7c"
); //問い合わせ関連
var downloadSheet = SpreadsheetApp.openById(
  "1k_mNosekLWAWNAipc62eHaKxEpObEPar3JRIQQMIekA"
); //資料ダウンロード
var toSheetName; //書き込み先シート名を格納する。createSheets()でシート名を作成してる。

//シート作成
function createSheets(sheet) {
  var data = new Date();
  var year = data.getYear().toString().slice(-2);
  var month = ("0" + (data.getMonth() + 1)).slice(-2); //+1で当月になる。
  var sheetName = "FY" + year + "." + month;
  var arr = new Array();

  if (sheet.getId() === spreadsheet.getId()) {
    var count = sheet.getSheets().length;
    var header = new Array([
      "お問い合わせ種別",
      "送信日時",
      "姓",
      "名",
      "姓カナ",
      "名カナ",
      "電話番号",
      "メールアドレス",
      "企業名",
      "企業URL",
      "部署役職",
      "お問い合わせ内容",
    ]);

    //シート名の配列を作る。
    for (var i = 0; i < count; i++) {
      arr.push(sheet.getSheets()[i].getName());
    }
    //シート名の配列から変数sheetNameと一致してるシートを探す。
    var even = function (element) {
      return element === sheetName;
    };
    //シート名の配列から変数sheetNameと一致してるシートがなければ、新しくシートを作る。
    //新しいシートが作成された場合、１行目に変数headerの要素を割り当て、太字にしてフィルターをONにする。
    if (arr.some(even) === false) {
      sheet.insertSheet(sheetName, 1);
      sheet
        .getSheetByName(sheetName)
        .getRange(1, 1, 1, header[0].length)
        .setValues(header)
        .setFontWeight("bold")
        .createFilter();
    }
    toSheetName = sheetName;
  } else if (sheet.getId() === downloadSheet.getId()) {
    var count = sheet.getSheets().length;
    var header = new Array([
      "送信日時",
      "ダウンロード希望資料",
      "目的",
      "企業名",
      "姓",
      "名",
      "姓カナ",
      "名カナ",
      "電話番号",
      "メールアドレス",
    ]);

    //シート名の配列を作る。
    for (var i = 0; i < count; i++) {
      arr.push(sheet.getSheets()[i].getName());
    }
    //シート名の配列から変数sheetNameと一致してるシートを探す。
    var even = function (element) {
      return element === sheetName;
    };
    //シート名の配列から変数sheetNameと一致してるシートがなければ、新しくシートを作る。
    //新しいシートが作成された場合、１行目に変数headerの要素を割り当て、太字にしてフィルターをONにする。
    if (arr.some(even) === false) {
      sheet.insertSheet(sheetName, 0);
      sheet
        .getSheetByName(sheetName)
        .getRange(1, 1, 1, header[0].length)
        .setValues(header)
        .setFontWeight("bold")
        .createFilter();
    }
    toSheetName = sheetName;
  }
}

function doPost(e) {
  var json = JSON.parse(e.postData.contents);
  /* リクエスト用パラメータ・URLの準備 */
  var params = {
    headers: { "X-ChatWorkToken": API_TOKEN },
    method: "post",
  };
  var str = json.webhook_event.body;

  var roomId = json.webhook_event.room_id;
  url = "https://api.chatwork.com/v2/rooms/" + roomId + "/messages";

  /* json内に「info」メッセージがあればチャットワークに送信 */
  if (str != "" || str != null || str != undefined) {
    str.replace(/\r?\n/g, "").match(/^\[info\].*\[\/info\]/);
  } else {
    return;
  }
  createColumns(json, str);

  //var body = '動いた';
  //params.payload = {body :body};

  //UrlFetchApp.fetch(url, params);
}

function createColumns(json, str) {
  var list = new Array();
  var arr = new Array();
  var check0 = /^\[info\]/;
  var check1 = /\[お問い合わせ種別\]/;
  var check2 = /dtext/;
  var check3 = /\[ダウンロード希望資料\]/;

  if (str.match(check0) && str.match(check1) && !str.match(check2)) {
    createSheets(spreadsheet);

    list.push(
      str
        .match(/\[お問い合わせ種別\].+/)
        .toString()
        .replace("[お問い合わせ種別]  ", "")
    );
    list.push(new Date(json.webhook_event.send_time * 1000));
    list.push(
      str
        .match(/\[姓\].+/)
        .toString()
        .replace("[姓]  ", "")
    );
    list.push(
      str
        .match(/\[名\].+/)
        .toString()
        .replace("[名]  ", "")
    );
    list.push(
      str
        .match(/\[姓カナ\].+/)
        .toString()
        .replace("[姓カナ]  ", "")
    );
    list.push(
      str
        .match(/\[名カナ\].+/)
        .toString()
        .replace("[名カナ]  ", "")
    );
    list.push(
      str
        .match(/\[電話番号\].+/)
        .toString()
        .replace("[電話番号]  ", "'")
    );
    list.push(
      str
        .match(/\[メールアドレス\].+/)
        .toString()
        .replace("[メールアドレス]  ", "")
    );
    list.push(
      str
        .match(/\[企業名\].+/)
        .toString()
        .replace("[企業名]  ", "")
    );
    list.push(
      str
        .match(/\[企業URL\].+/)
        .toString()
        .replace("[企業URL]  ", "")
    );
    list.push(
      str
        .match(/\[部署役職\].+/)
        .toString()
        .replace("[部署役職]  ", "")
    );
    list.push(
      str
        .match(/\[お問い合わせ内容\] ([\s\S]*)\n\n/)[0]
        .toString()
        .replace("[お問い合わせ内容]  ", "")
        .replace(/\n\n/, "")
    );

    arr.push(list);
    spreadsheet.getSheetByName(toSheetName).insertRows(2, 1);
    spreadsheet
      .getSheetByName(toSheetName)
      .getRange(2, 1, 1, list.length)
      .setValues(arr);
  } else if (str.match(check0) && !str.match(check2) && str.match(check3)) {
    createSheets(downloadSheet);

    list.push(new Date(json.webhook_event.send_time * 1000));
    list.push(
      str
        .match(/\[ダウンロード希望資料\].+/)
        .toString()
        .replace("[ダウンロード希望資料]  ", "")
    );
    list.push(
      str
        .match(/\[目的\].+/)
        .toString()
        .replace("[目的]  ", "")
    );
    list.push(
      str
        .match(/\[企業名\].+/)
        .toString()
        .replace("[企業名]  ", "")
    );
    list.push(
      str
        .match(/\[姓\].+/)
        .toString()
        .replace("[姓]  ", "")
    );
    list.push(
      str
        .match(/\[名\].+/)
        .toString()
        .replace("[名]  ", "")
    );
    list.push(
      str
        .match(/\[姓カナ\].+/)
        .toString()
        .replace("[姓カナ]  ", "")
    );
    list.push(
      str
        .match(/\[名カナ\].+/)
        .toString()
        .replace("[名カナ]  ", "")
    );
    list.push(
      str
        .match(/\[電話番号\].+/)
        .toString()
        .replace("[電話番号]  ", "'")
    );
    list.push(
      str
        .match(/\[メールアドレス\].+/)
        .toString()
        .replace("[メールアドレス]  ", "")
    );

    arr.push(list);
    downloadSheet.getSheetByName(toSheetName).insertRows(2, 1);
    downloadSheet
      .getSheetByName(toSheetName)
      .getRange(2, 1, 1, list.length)
      .setValues(arr);
  } else if (str.match(check0) && !str.match(check1) && !str.match(check2)) {
    list.push(new Date(json.webhook_event.send_time * 1000));
    list.push(
      str
        .match(/\[氏名\].+/)
        .toString()
        .replace("[氏名]  ", "")
    );
    list.push(
      str
        .match(/\[メールアドレス\].+/)
        .toString()
        .replace("[メールアドレス]  ", "")
    );
    list.push(
      str
        .match(/\[企業名\].+/)
        .toString()
        .replace("[企業名]  ", "")
    );
    list.push(
      str
        .match(/\[電話番号\].+/)
        .toString()
        .replace("[電話番号]  ", "'")
    );
    list.push(
      str
        .match(/\[お問い合わせ\] ([\s\S]*)\n\n/)[0]
        .toString()
        .replace("[お問い合わせ]  ", "")
        .replace(/\n\n/, "")
    );

    arr.push(list);
    spreadsheet.getSheetByName("LP").insertRows(2, 1);
    spreadsheet
      .getSheetByName("LP")
      .getRange(2, 1, 1, list.length)
      .setValues(arr);
  }
}
