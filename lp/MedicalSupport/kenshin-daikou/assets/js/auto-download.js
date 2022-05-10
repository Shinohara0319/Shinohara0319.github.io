/** URLから自動DLさせる関数 */
function downloadFromUrlAutomatically(url, fileName) {
  setTimeout(() => {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.responseType = "blob";
    xhr.onload = function (e) {
      if (this.status == 200) {
        var urlUtil = window.URL || window.webkitURL;
        var imgUrl = urlUtil.createObjectURL(this.response);
        var link = document.createElement("a");
        link.href = imgUrl;
        link.download = fileName;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      }
    };
    xhr.send();
  }, 1000);
}
