/*チャットワークのinfoに流れてきた問い合わせが、「Sphere、および他プロダクトのご利用・広告ご出稿に関するお問合わせ」だったら、小池さんにメンション飛ばす。*/
var API_TOKEN = "56f3b3822a8220455d15457482741ec1"; //チャットワークAPIトークン
//乱数でおみくじの結果を生成
function postMessage() {
  var results = [
    "がんばれ！",
    "気合いだ！",
    "負けるな！",
    "連絡して！",
    "がんばれ！がんばれ！",
    "がんばれp(^_^)q",
    "がんばれー*\\(^o^)/*",
  ];
  return results[Math.floor(Math.random() * results.length)];
}

function doPost(e) {
  var json = JSON.parse(e.postData.contents);
  /* リクエスト用パラメータ・URLの準備 */
  var params = {
    headers: { "X-ChatWorkToken": API_TOKEN },
    method: "post",
  };

  var roomId = json.webhook_event.room_id;
  url = "https://api.chatwork.com/v2/rooms/" + roomId + "/messages";

  var message = json.webhook_event.body;
  var check0 = /^\[info\]/;
  var check1 = /dtext/;
  var check2 = /\[\?+\].+\n\[\?+\]/; //文字化け対策
  var check3 = /\[ダウンロード希望資料\]/;
  var check4 = /\[お問い合わせ種別\].+Sphere、および他プロダクトのご利用・広告ご出稿に関するお問合わせ/;
  var check5 = /\[お問い合わせ種別\]/;
  var check6 = /[\u{3041}-\u{3093}]/mu; //ひらがな
  var body = /\[お問い合わせ内容\].+/;
  console.log(body);

  /* json内に「Sphere、および他プロダクトのご利用に〜」にマッチするメッセージであればチャットワークに送信 */
  if (
    message.match(check0) &&
    !message.match(check1) &&
    !message.match(check2) &&
    !message.match(check3) &&
    (message.match(check4) || !message.match(check5)) &&
    check6.test(body)
  ) {
    //var accountId = 2400224; マーベリックさんテスト用
    var accountId1 = 1131876; //Biz小池さんのaid
    var accountId2 = 2931884; //Biz森川さんのaid
    var messageId = json.webhook_event.message_id;

    var body = "";
    body += "[rp aid=" + accountId1;
    body += " to=" + roomId + "-" + messageId + "] ";
    body += "[rp aid=" + accountId2;
    body += " to=" + roomId + "-" + messageId + "] ";
    body += postMessage();
    params.payload = { body: body };

    UrlFetchApp.fetch(url, params);
  }
}
