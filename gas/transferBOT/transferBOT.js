var API_TOKEN = "79969883c0dc2e1cddabcf020e8b5411"; //新山さんのチャットワークAPIトークン。
/*トークン持ち主の新山さんのchatworkアカウントでしか使えません。*/

function doPost(e) {
  var json = JSON.parse(e.postData.contents);
  /* リクエスト用パラメータ・URLの準備 */
  var params = {
    headers: { "X-ChatWorkToken": API_TOKEN },
    method: "post",
  };

  var roomId = json.webhook_event.room_id;
  var forwardingRoomId = "140633128"; //新山さんの転送先roomId
  url = "https://api.chatwork.com/v2/rooms/" + forwardingRoomId + "/messages";

  /* 送信されてきたメッセージのTOに新山さん(id:3331935)が入ってるメッセージは全て転送する。 */
  if (json.webhook_event.body.match(/\[To:3331935\]/)) {
    var accountId = json.webhook_event.account_id;
    var messageId = json.webhook_event.message_id;
    var time = json.webhook_event_time;
    var name = json.webhook_event.body
      .replace(/\[To:.+\] /, "")
      .replace(/\n/g, "|")
      .replace(/\|.+/g, "");

    var body = "";
    body += "以下、" + messageId + "からです。";
    body +=
      "[qt][qtmeta picon={" +
      accountId +
      "} aid={" +
      accountId +
      "} time={" +
      time +
      "}]";
    body += json.webhook_event.body + "[/qt]";
    params.payload = { body: body };

    UrlFetchApp.fetch(url, params);
  }
}
