var ajax = {
  send: function (object, type) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
      var message = "";
      switch (request.readyState) {
        case 0:
          message = "open hasn't been called";
          break;
        case 1:
          message = "send hasn't been called";
          break;
        case 2:
          message = "send has been called and header received";
          break;
        case 3:
          message = "data gets downloaded";
          break;
        case 4:
          message = "finished process"
          break;
        default:
          message = "unknown"
          break;
      }

      if (request.readyState === 4 && request.status === 200) {
        if (settings.development === true) {
          console.log(message, request.responseText);
        }
        if (!isNaN(request.responseText)) {
          content.id = request.responseText;
        }
      }
    }

    var flag = 0;
    switch (type) {
      case "photo":
        flag = 1;
        break;
      case "position":
        flag = 2;
        break;
      case "login":
        flag = 3;
        break;
      default:
        flag = 0;
        break;
    }

    var stringObject = JSON.stringify(object);
    var compressedObject = LZW.compress(stringObject);

    request.open("POST", settings.path + "/backend/interface/post.php?flag=" + flag, true);
    request.setRequestHeader("Content-type", "application/json");
    request.send(compressedObject);
  }
}