/*【重要】取得したい人のカレンダーを一度開かないと、その人のカレンダーはapiで取れない。
人、年月単位で各項目名に対応するカレンダーの予定がどの程度入っているかSpreadsheetに出力する関数。
 スプレッドシートからのインプット情報: 
 inputDate: 処理対象年月 入力がなければ今の年月を対象とする。 submit!!!!!シート B1セル 
 addresses: 調査対象のネオキャリアメールアドレス一覧 addressesシートのA列（ヘッダー除く）
*/

function createManHour() {
  var workSpreadSheet = SpreadsheetApp.openById(
    "1gQ6ulsBdy1VgkiMccvaDJBDjoplCngBetqhSvl492hA"
  );
  var addressSheet = workSpreadSheet.getSheetByName("addresses");
  var addresses = addressSheet
    .getRange(1, 1, addressSheet.getLastRow())
    .getValues()
    .map(function (row) {
      return row[0];
    })
    .filter(function (id, i) {
      return id !== "" && i !== 0;
    });
  var workSheet = workSpreadSheet.getSheetByName("manHoursList");

  var targetYYYYMM = getYYYYMM(new Date());
  var currentDate = new Date();
  var targetDate = new Date();
  var inputDate = workSpreadSheet
    .getSheetByName("submit!!!!!")
    .getRange(1, 2)
    .getDisplayValue();
  if (isYYYYMM(inputDate)) {
    targetYYYYMM = inputDate;
    targetDate.setYear((inputDate - 1).toString().substr(0, 4));
    targetDate.setMonth((inputDate - 1).toString().substr(4, 2));
  }

  // プロダクトのリストはmanHoursListシートのヘッダの状況見てうまいこと取得してください。
  var productHeaderIndexOf = 3; // manHoursListのヘッダのプロダクト名が始まる列
  var productList = workSheet
    .getRange(
      1,
      productHeaderIndexOf,
      1,
      workSheet.getLastColumn() - productHeaderIndexOf
    )
    .getValues()[0];
  var productListReg = productList.map(function (product) {
    return new RegExp(product, "i");
  });

  addresses.forEach(function (address) {
    var manHours = productListReg.map(function (e) {
      return 0;
    });
    var calendar = CalendarApp.getCalendarById(address);
    if (calendar != null) {
      var calendarEvents = calendar.getEvents(
        getFirstDateTime(targetDate),
        getLastDateTime(targetDate)
      );
      var calendarStatus = calendarEvents.filter(function (a) {
        var guestStatus = CalendarApp.GuestStatus;
        var guest = a.getGuestByEmail(address);

        return (
          a.getGuestList().length == 0 ||
          (guest &&
            (guest.getGuestStatus() == guestStatus.YES ||
              guest.getGuestStatus() == guestStatus.OWNER))
        );
      });
      manHours = productListReg.map(function (productReg, i) {
        return calendarStatus
          .filter(function (event) {
            return productReg.test(event.getTitle());
          })
          .map(function (event) {
            return (
              (event.getEndTime() - event.getStartTime()) / (1000 * 60 * 60)
            );
          })
          .reduce(function (acc, cur) {
            return acc + cur;
          }, 0);
      });
    }

    var mailAndDate = workSheet
      .getRange(1, 1, workSheet.getLastRow(), 2)
      .getDisplayValues()
      .map(function (row) {
        return row[0] + row[1];
      });
    var targetRow = workSheet.getLastRow() + 1;
    if (mailAndDate.indexOf(address + targetYYYYMM) !== -1) {
      targetRow = mailAndDate.indexOf(address + targetYYYYMM) + 1;
    }

    // 対象行を1行置換。
    workSheet
      .getRange(targetRow, 1, 1, productHeaderIndexOf - 1)
      .setValues([[address, targetYYYYMM]]);
    workSheet
      .getRange(
        targetRow,
        productHeaderIndexOf,
        1,
        workSheet.getLastColumn() - productHeaderIndexOf
      )
      .setValues([manHours])
      .setNumberFormat("0.00");
    workSheet
      .getRange(targetRow, workSheet.getLastColumn())
      .setValues([[currentDate]])
      .setNumberFormat("yyyy/mm/dd hh:mm:ss");
  });
}

function getYYYYMM(date) {
  var year = date.getFullYear().toString();
  var month = ("00" + (date.getMonth() + 1)).slice(-2);
  return year + month;
}

function getFirstDateTime(date) {
  return new Date(date.getFullYear(), date.getMonth(), 1);
}

function getLastDateTime(date) {
  return new Date(date.getFullYear(), date.getMonth() + 1, 0, 23, 59, 59);
}

function isYYYYMM(yyyymm) {
  var result = false;
  if (
    yyyymm == undefined ||
    yyyymm === "" ||
    typeof yyyymm !== "string" ||
    yyyymm.length !== 6 ||
    isNaN(yyyymm)
  ) {
    result = false;
  } else if (
    Number(yyyymm.substr(0, 4)) < 2000 ||
    Number(yyyymm.substr(4, 2)) == 0 ||
    Number(yyyymm.substr(4, 2)) > 12
  ) {
    result = false;
  } else {
    result = true;
  }
  return result;
}
