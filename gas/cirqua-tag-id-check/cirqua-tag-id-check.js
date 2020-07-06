/*cirquaタグのidチェックを機械的に行う。*/
var API_TOKEN = 'a1b003618478c1c19e0afb35db339ca6';　//チャットワークAPIトークン

/*広告枠UIDだけを抽出、配列に格納して返す*/
function getTasks(taskid, slotid){
  var params = {
    headers : {'X-ChatWorkToken' : API_TOKEN},
    method : 'get'
  };

  var url = 'https://api.chatwork.com/v2/my/tasks?status=open';
  var strRespons = UrlFetchApp.fetch(url, params);

  if(strRespons == '') return false;

  var json = JSON.parse(strRespons.getContentText());
  var tasks = [];
  var replaceMessages = new RegExp([
    '\http.+',
    '\コピー元UID(.|\\s)*',
    '\タスクID.+',
  ].join('|'), 'g');
    
  var replaceId = new RegExp([
    '\"',
    'data-slot-id=',
  ].join('|'), 'g');
  
  var success = {};

  //slotidは作成UID、res.bodyは依頼ID
  for each (var res in json) {
    if (res.body.match('タスクID: ' + taskid)) {
      res.body = res.body.replace(replaceMessages, '');
      res.body = res.body.match(/[0-9a-zA-Z]{8}/g);
      for (var i = 0; i < slotid.length; i++) {
        slotid[i] = slotid[i].replace(replaceId, '');
        for (var l = 0; l < res.body.length; l++) {
          success[slotid[i]] = success[slotid[i]] || slotid[i] === res.body[l];
        }
      }
      for (var key in success) {
        if (success[key]) {
          tasks.push('【成功】: ' + key + '\n');
        } else {
          tasks.push('失敗!!!!: ' + key + '\n');
        }
      }
    }
  }
  return tasks;
}

function doPost(e) {
  var json = JSON.parse(e.postData.contents);
  /* リクエスト用パラメータ・URLの準備 */
  var params = {
    headers : {'X-ChatWorkToken' : API_TOKEN},
    method : 'post'
  };

  var roomId = json.webhook_event.room_id;
  var message = json.webhook_event.body;
  url = 'https://api.chatwork.com/v2/rooms/' + roomId + '/messages';

  /* json内に「おみくじ」メッセージがあればチャットワークに送信 */
  if(message.match(/^[0-9a-zA-Z]{10} --check/) && !message.match(/取得したメッセージ/)){
    var accountId = json.webhook_event.account_id;
    var messageId = json.webhook_event.message_id;
    var taskId = message.match(/^[0-9a-zA-Z]{10}/);
    var slotId = message.match(/data-slot-id="[0-9a-zA-Z]{8}"/g);

    var body = '';

    body += '[rp aid=' + accountId;
    body += ' to=' + roomId + '-' + messageId + '] ';
    body += '[info]idチェック結果\n' + getTasks(taskId, slotId) + '[/info]'
    params.payload = {body :body};

    UrlFetchApp.fetch(url, params);
  } else if (message.match(/--check/) && !message.match(/^[0-9a-zA-Z]{10} --check/) && !message.match(/失敗/)) {
    var accountId = json.webhook_event.account_id;
    var messageId = json.webhook_event.message_id;

    var body = '';

    body += '[rp aid=' + accountId;
    body += ' to=' + roomId + '-' + messageId + '] ';
    body += '[info]タスクの取得に失敗しました。\nIDの間違いがないか確認してください。[/info]'
    params.payload = {body :body};

    UrlFetchApp.fetch(url, params);
  }
}
