var API_TOKEN = "56f3b3822a8220455d15457482741ec1"; //チャットワークAPIトークン
var spreadsheet = SpreadsheetApp.openById(
  "1Sgb_olkCVInUHIRWYChGGicLYzR0AQ6q5ADtAN6DmkU"
);
var toSheetName = spreadsheet.getSheetByName("【bot】スクリプト");

function getLastRow(sheetName) {
  var row;
  var range = sheetName.getRange("A:B").getValues();
  for1: for (var i = range.length - 1; i >= 0; i--) {
    for (var j = 0; j < range[i].length; j++) {
      if (range[i][j] != "") {
        break for1;
      }
    }
  }
  return (row = i + 1);
}

//スプシのH1に入力された数値に+1する。H1の数値 < データが入ってる最終行の場合、初期値(4)に戻す。
function updateCount(sheetName) {
  var row = sheetName.getRange("H1").getValue();
  if (row < getLastRow(sheetName)) {
    sheetName.getRange("H1").setValue(row + 1);
  } else {
    sheetName.getRange("H1").setValue(4);
  }
}

//スプシに格納されたデータを読み込んでメッセージを生成
function generateMessage(sheetName) {
  var row = sheetName.getRange("H1").getValue();
  var title = sheetName.getRange("A3").getValue();
  var body = sheetName.getRange("A" + row).getValue();

  var message = "[info][title]" + title + "[/title]" + body + "[/info]";
  return message;
}

//チャットワークにメッセージを送信
function doPost() {
  var client = ChatWorkClient.factory({ token: API_TOKEN }); // Chatwork API
  client.sendMessage({
    room_id: 189828365, // room ID
    body: generateMessage(toSheetName),
  }); // message

  updateCount(toSheetName);
}
