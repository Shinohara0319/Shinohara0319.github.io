/*変数room_idに格納してるチャットワークの部屋だけ、ToにMaverickさんがあるチャットをslackのgeneralに転送するBOT。*/
/*通称アカネチャンBOT*/
var CHATWORK_TOKEN = "a1b003618478c1c19e0afb35db339ca6";
var SLACK_TOKEN =
  "xoxp-2549257218-98687259573-408890890839-5b1626cd7304b0077e8bc3d866390870";
var room_id = ["25562858", "128071747"]; //25562858:マーベリックチャット, 128071747:広報

function getMessage() {
  var params = {
    headers: { "X-ChatWorkToken": CHATWORK_TOKEN },
    method: "get",
  };
  for (var i = 0; i < room_id.length; i++) {
    var url =
      "https://api.chatwork.com/v2/rooms/" + room_id[i] + "/messages?force=0"; //チャットからメッセージを取得
    var strRespons = UrlFetchApp.fetch(url, params); //チャットワークAPIエンドポイントからレスポンスを取得

    if (strRespons == "") continue;

    var json = JSON.parse(strRespons.getContentText()); ///APIからの結果をjson形式にパース

    var info = json.filter(function (j) {
      return /\[To:2400224\]/.test(j.body);
    });
    var message = "";
    var replaceMessages = new RegExp(
      [
        "\\[To:.+\\].+",
        "\\[toall\\]",
        "\\(bow\\)",
        "\\[title\\]",
        "\\[/title\\]",
        "\\[info\\]",
        "\\[/info\\]",
        "\\[qt\\]",
        "\\[/qt\\]",
        "\\[qtmeta.+\\]",
      ].join("|"),
      "g"
    );

    info.forEach(function (v) {
      var body = v.body
        .replace(replaceMessages, "")
        .replace(/\n{3,}/g, /\n\n/)
        .replace(/^\n+/, "");
      message =
        message +
        " " +
        "発信者: " +
        v.account.name +
        "さん\n```" +
        body +
        "\n```";
      postMessage(message);
    });
  }
}

function postMessage(message) {
  var url = "https://slack.com/api/chat.postMessage";
  var token = SLACK_TOKEN;
  var channel = "1_general";
  var username = "BIZからのアナウンスをお知らせしてくれるアカネチャンBOT";
  var parse = "full";
  var icon_emoji = ":akanechan:"; //表示するアイコン
  var method = "post";

  var payload = {
    token: token,
    channel: channel,
    text: message,
    username: username,
    parse: parse,
    icon_emoji: icon_emoji,
  };

  var params = {
    method: method,
    payload: payload,
  };

  //slackにポスト
  var response = UrlFetchApp.fetch(url, params);
}
