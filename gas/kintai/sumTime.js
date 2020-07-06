//全てのシートを取得
var spreadsheet = SpreadsheetApp.openById(
  "12ETqogfYst8XUTV9ZkckfuwzSbnFyXaKYNAIBN5cnAs"
);
//コピー先をシート名で指定。ここは固定で良さそう。
var copySheetTo = spreadsheet.getSheetByName("COPY_ALL");
//除外したいシート名を指定。
var excSheets = spreadsheet
  .getSheetByName("_設定")
  .getRange("B3")
  .getValue()
  .split(",");
//除外したいシートが不足してるので追加。
excSheets.push("_設定", "_メッセージ", "COPY_ALL");

//全てのシート名を取得
function getAllSheetNames() {
  var sheets = spreadsheet.getSheets();
  var sheetNames = new Array();
  if (sheets.length >= 1) {
    for (var i = 0; i < sheets.length; i++) {
      sheetNames.push(sheets[i].getName());
    }
  }
  return sheetNames;
}

//全てのシートと除外したいシートを比較して、差分で新しい配列を作る。
function sheetCompare() {
  var arr1 = getAllSheetNames();
  //全てのシートが入ってるarr1から、indexOfから返ってきたシートを削除してる。名前でマッチ。
  return arr1.filter(function (v) {
    //indexOfで、存在しないものは-1を返す。不要なシートを取得してる。
    return excSheets.indexOf(v) == -1;
  });
}

//前月の合計労働時間を算出する関数。月初のみ動かす。
function sumLastMonth() {
  var row;
  var name = sheetCompare();
  var date = new Date();
  var year = date.getFullYear();
  var month = date.getMonth(); //ここに+1すると来月ぶん取得になる。
  if (month == 0) {
    month = 12;
    year -= 1;
  }

  for (var i = 0; name.length > i; i++) {
    var range = spreadsheet.getSheetByName(name[i]).getRange("A:E").getValues();
    for1: for (var j = range.length - 1; j >= 0; j--) {
      for (var k = 0; k < range[j].length; k++) {
        if (range[j][k] != "") {
          break for1;
        }
      }
    }
    row = j + 1;

    var toSheet = spreadsheet.getSheetByName(name[i]);
    var sumColumnSet = toSheet.getRange("G1").getValues();
    if (
      sumColumnSet == undefined ||
      sumColumnSet == "" ||
      sumColumnSet == null
    ) {
      toSheet.getRange("G1").setValue("前月合計勤務時間");
    }
    //各利用者シートのA~E列の5行目からデータの存在する最終行まで一括取得。
    var toSheetColumn = toSheet.getRange("A5:" + "F" + row).getValues();
    //変数valuesに、範囲取得したデータの値が「前月」かつ「空白文字」以外の配列を作成。
    var lastMonthHours = 0;
    var lastMonthMinutes = 0;
    var lastMonthTime = 0;
    toSheetColumn.filter(function (v) {
      if (
        v[1] != undefined &&
        v[1] != "" &&
        v[1] != null &&
        v[1].getMonth() + 1 == month &&
        v[1].getFullYear() == year &&
        v[2] != undefined &&
        v[2] != "" &&
        v[2] != null &&
        v[2] != "-" &&
        v[3] != "-" &&
        v[5] != "#N/A" &&
        v[5] != ""
      ) {
        lastMonthHours += v[5].getHours() * 60;
        lastMonthMinutes += v[5].getMinutes();
        return (lastMonthTime = (lastMonthHours + lastMonthMinutes) / 60);
      }
    });

    //前月合計勤務時間を各シートに挿入。
    toSheet.getRange("H1").setNumberFormat("#,##0.00");
    toSheet.getRange("H1").setValue(lastMonthTime);
  }
}

//当月の合計労働時間を算出する関数。毎日動かす。
function sumThisMonth() {
  var row;
  var name = sheetCompare();
  var count = name.length;
  var date = new Date();
  var year = date.getYear();
  var month = date.getMonth(); //当月のみ

  for (var i = 0; count > i; i++) {
    var range = spreadsheet.getSheetByName(name[i]).getRange("A:E").getValues();
    for1: for (var j = range.length - 1; j >= 0; j--) {
      for (var k = 0; k < range[j].length; k++) {
        if (range[j][k] != "") {
          break for1;
        }
      }
    }
    row = j + 1;

    var toSheet = spreadsheet.getSheetByName(name[i]);
    var sumColumnSet = toSheet.getRange("G2").getValues();
    if (
      sumColumnSet == undefined ||
      sumColumnSet == "" ||
      sumColumnSet == null
    ) {
      toSheet.getRange("G2").setValue("当月合計勤務時間");
    }

    //各利用者シートのA~E列の5行目からデータの存在する最終行まで一括取得。
    var toSheetColumn = toSheet.getRange("A5:" + "F" + row).getValues();
    //変数valuesに、範囲取得したデータの値が「前月」かつ「空白文字」以外の配列を作成。
    var thisMonthHours = 0;
    var thisMonthMinutes = 0;
    var thisMonthTime = 0;
    toSheetColumn.filter(function (v) {
      if (
        v[1] != undefined &&
        v[1] != "" &&
        v[1] != null &&
        v[1].getMonth() == month &&
        v[1].getYear() == year &&
        v[2] != undefined &&
        v[2] != "" &&
        v[2] != null &&
        v[2] != "-" &&
        v[3] != "-" &&
        v[5] != "#N/A" &&
        v[5] != ""
      ) {
        thisMonthHours += v[5].getHours() * 60;
        thisMonthMinutes += v[5].getMinutes();
        return (thisMonthTime = (thisMonthHours + thisMonthMinutes) / 60);
      }
    });

    //前月合計勤務時間を各シートに挿入。
    toSheet.getRange("H2").setNumberFormat("#,##0.00");
    toSheet.getRange("H2").setValue(thisMonthTime);
  }
}
