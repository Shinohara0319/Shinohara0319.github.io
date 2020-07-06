var spreadsheet = SpreadsheetApp.openById(
  "17v7U1MC3wpa1z8XPTgT3tt6pAu-_ZbAcQZJSKjh633Y"
);
var sheet = spreadsheet.getSheetByName("list");

function doPost(e) {
  var token = PropertiesService.getScriptProperties().getProperty(
    "SLACK_ACCESS_TOKEN"
  );
  var slackApp = SlackApp.create(token); //SlackApp インスタンスの取得
  var params = JSON.parse(e.postData.getDataAsString());
  var user = params.event.user;
  var username = "";
  var messages = params.event.text;
  var listUrl = "https://slack.com/api/users.list?token=" + token;
  var response = JSON.parse(UrlFetchApp.fetch(listUrl)); //slackの表示名一覧を取得。
  var book = undefined;
  var date = new Date();
  date =
    date.getFullYear() + "/" + (date.getMonth() + 1) + "/" + date.getDate();

  var options = {
    channelId: "#library", //チャンネル名
    userName: "libraryBOT", //投稿するbotの名前
    iconEmoji: ":eru:",
    linkNames: 1,
  };

  for (var i = 0; i < response.members.length; i++) {
    if (response.members[i].id == user) {
      book = getColumns(messages);
      username = response.members[i].name;
    }
  }

  if (!/--/.test(messages)) {
    options.message =
      "<@" +
      user +
      "> さん、こんにちは！\nコマンドを知りたい時は\n```\n@libraryBOT --help\n```\nと入力して下さいね！";
  } else if (book == undefined && /--/.test(messages)) {
    options.message =
      "<@" +
      user +
      "> さん、ごめんなさい。該当の書籍が見つかりませんでした...\n引数同士のスペースが全角になってないか、確認してもらえませんか...？\n" +
      "TRUE例\n```\n@libraryBOT --書籍名 or 書籍番号 貸して\n```" +
      "\nFALSE例\n```\n@libraryBOT --書籍名 or 書籍番号　貸して\n```";
  } else if (
    /--.+借/.test(messages) ||
    /--.+貸/.test(messages) ||
    /--.+rental/.test(messages)
  ) {
    if (book.status != "貸出中") {
      sheet
        .getRange("G" + book.row + ":I" + book.row)
        .setValues([["貸出中", date, username]]);
      options.message =
        "<@" +
        user +
        "> 私、気になります！\n「" +
        book.name +
        "」をお貸ししますね。";
    } else if (book.status == "貸出中") {
      options.message =
        "<@" +
        user +
        "> 私、気になります！\n「" +
        book.name +
        "」は貸し出し中のはずです。\n最後に借りたのは" +
        book.borrower +
        "さんだったと思います。";
    }
  } else if (/--.+返/.test(messages) || /--.+return/.test(messages)) {
    if (book.status == "貸出中") {
      sheet
        .getRange("G" + book.row + ":I" + book.row)
        .setValues([["返却済み", date, username]]);
      options.message =
        "<@" +
        user +
        "> 私、気になります！\n「" +
        book.name +
        "」、確かに受け取りました。また借りに来てくださいね？";
    } else if (book.status == "返却済み") {
      options.message =
        "<@" +
        user +
        "> 私、気になります！\n「" +
        book.name +
        "」は前に" +
        book.borrower +
        "さんが返してくださいましたよ？何かの間違いじゃないでしょうか...？";
    } else if (book.status == "") {
      options.message =
        "<@" +
        user +
        "> え？？私、「" +
        book.name +
        "」は貸してなかったと思いますよ？";
    }
  } else if (book.status == "リスト" && /--/.test(messages)) {
    options.message =
      "<@" +
      user +
      "> さん、ようこそ！私が管理してる書籍番号と書籍名はこちらです！\n----------\n" +
      getBookList() +
      "\n----------";
  } else if (book.status == "ヘルプ" && /--/.test(messages)) {
    options.message =
      "<@" +
      user +
      "> さん、こんにちは！" +
      "\n借りたい場合は\n```\n@libraryBOT --書籍名 or 書籍番号 + rental or 借を含む文字列 or 貸を含む文字列\n```" +
      "\n返したい場合は\n```\n@libraryBOT --書籍名 or 書籍番号 + return or 返を含む文字列\n```" +
      "\n本のリストを見たい場合は\n```\n@libraryBOT --リスト or list\n```" +
      "\nとコメントしてくださいね。";
  }

  slackApp.postMessage(options.channelId, options.message, {
    username: options.userName,
    icon_emoji: options.iconEmoji,
    link_names: options.linkNames,
  });

  //バリデーション用
  return ContentService.createTextOutput(params.challenge);
}

function doGet(e) {
  doPost(e);
}

function getColumns(mes) {
  var cols = sheet.getRange(2, 2, sheet.getLastRow(), 2).getValues();
  var bookname = replaceMessages(mes);
  var matchWord = new RegExp(
    ["借", "貸", "rental", "返", "return"].join("|"),
    "g"
  );

  for (var i = 0; i < cols.length; i++) {
    cols[i][1] = replaceMessages(cols[i][1]);
    for (var j = 0; j < cols[i].length; j++) {
      if (cols[i][j] == bookname && mes.match(matchWord)) {
        var bookdata = sheet
          .getRange("A" + (cols[i][0] + 1) + ":I" + (cols[i][0] + 1))
          .getValues();
        return {
          no: bookdata[0][1],
          name: bookdata[0][2],
          status: bookdata[0][6],
          borrower: bookdata[0][8],
          row: cols[i][0] + 1,
        };
      } else if (mes.match(/リスト/) || mes.match(/list/)) {
        return {
          status: "リスト",
        };
      } else if (mes.match(/ヘルプ/) || mes.match(/help/)) {
        return {
          status: "ヘルプ",
        };
      }
    }
  }
}

function getBookList() {
  var booklist = sheet
    .getRange(2, 2, sheet.getLastRow(), 2)
    .getValues()
    .filter(function (e) {
      if (e[0] != "" && e[1] != "") {
        return e;
      }
    });
  return booklist.join("\n");
}

function replaceMessages(mes) {
  var replaceWord = new RegExp(
    [
      "@libraryBOT",
      "貸.+",
      "借.+",
      "rental",
      "返.+",
      "return",
      "--",
      "\\ {2,}",
      "<@.+>",
    ].join("|"),
    "g"
  );
  var spaceDel = new RegExp(["^ {1,}", " {1,}$", " "].join("|"), "g");

  return mes.replace(replaceWord, "").replace("　", " ").replace(spaceDel, "");
}
