var jiarun = {
  onLoad: function() {
    // initialization code
    this.initialized = true;
    this.strings = document.getElementById("jiarun-strings");
  },

  onMenuItemCommand: function(e) {
    var promptService = Components.classes["@mozilla.org/embedcomp/prompt-service;1"]
                                  .getService(Components.interfaces.nsIPromptService);
    promptService.alert(window, this.strings.getString("helloMessageTitle"),
                                this.strings.getString("helloMessage"));
  },

  onToolbarButtonCommand: function(e) {
    // just reuse the function above.  you can change this, obviously!
    jiarun.onMenuItemCommand(e);
  }
};

window.addEventListener("load", function () {
  jiarun.onLoad();
}, false);

jiarun.onFirefoxLoad = function(event) {
  document.getElementById("contentAreaContextMenu")
          .addEventListener("popupshowing", function (e) {
    jiarun.showFirefoxContextMenu(e);
  }, false);
  
  const Cu = Components.utils;
  const Cc = Components.classes;
  const Ci = Components.interfaces;

  function _log(str) {
    // dump(str + "\n");
    Components.utils.reportError(str);
  }
  
  function _getContentFromURL(url) {
    var ioService = Cc['@mozilla.org/network/io-service;1'].getService(Ci.nsIIOService);
    var scriptableStream = Cc['@mozilla.org/scriptableinputstream;1'].getService(Ci.nsIScriptableInputStream);
        
    var channel = ioService.newChannel(url, null, null);
    var input = channel.open();
    scriptableStream.init(input);
    var str = scriptableStream.read(input.available());
    scriptableStream.close()
    input.close();
    
    var utf8Converter = Components.classes["@mozilla.org/intl/utf8converterservice;1"].
    getService(Components.interfaces.nsIUTF8ConverterService);
    return utf8Converter.convertURISpecToUTF8 (str, "UTF-8");
  }
  
  var alertsService = Components.classes["@mozilla.org/alerts-service;1"]
                    .getService(Components.interfaces.nsIAlertsService);
  function GM_notification(str) {
    alertsService.showAlertNotification("", str, "");
  }
  
  var audio = null;
  function playAudio() {
      if (!audio) {
        audio = new Audio("chrome://jiarun/content/song.ogg");
        audio.loop = false;
      }
      audio.play();
  }
  
  function _injectJS(view, js_src) {
    try {
      var sandbox = new Cu.Sandbox(view);
      sandbox.unsafeWindow = view.window.wrappedJSObject;
      sandbox.window = view.window;
      sandbox.document = sandbox.window.document;
      sandbox.JSON = JSON;
      sandbox.GM_notification = GM_notification;
      sandbox.playAudio = playAudio;
      sandbox.__proto__ = sandbox.window;
      
      js_src.forEach(function(src) {
         Cu.evalInSandbox(_getContentFromURL(src), sandbox);  
      });
    } catch (e) {
      _log(e);
    }
  }
  
  document.getElementById("appcontent").addEventListener("DOMContentLoaded", function(evt) {
    if (!evt.originalTarget instanceof HTMLDocument) {
      return;
    }
    
    var view = evt.originalTarget.defaultView;
    if (!view) {
      return;
    }

    if (new RegExp('www.365jiarun.com', "ig").test(view.document.location.href)) {
      _injectJS(view, ["chrome://jiarun/content/jquery.min.js", "chrome://jiarun/content/login.js"]);
    }

//    var queryPageUrl = Application.prefs.getValue("extensions.jiarun@gmail.com.queryPageUrl", "^$");
//    var productPageUrl = Application.prefs.getValue("extensions.jiarun@gmail.com.productPageUrl", "^$");
//    var loginPageUrl = Application.prefs.getValue("extensions.jiarun@gmail.com.loginPageUrl", "^$");
//
//    if (new RegExp(loginPageUrl, "ig").test(view.document.location.href)) {
//      _injectJS(view, ["chrome://jiarun/content/jquery.min.js", "chrome://jiarun/content/login.js"]);
//    }
//
//    if (new RegExp(queryPageUrl, "ig").test(view.document.location.href)) {
//      _injectJS(view, ["chrome://jiarun/content/jquery.min.js", "chrome://jiarun/content/login.js"]);
//    }
//
//    if (new RegExp(productPageUrl, "ig").test(view.document.location.href)) {
//      _injectJS(view, ["chrome://jiarun/content/jquery.min.js", "chrome://jiarun/content/login.js"]);
//    }
  }, false);
};

jiarun.showFirefoxContextMenu = function(event) {
  // show or hide the menuitem based on what the context menu is on
  document.getElementById("context-jiarun").hidden = gContextMenu.onImage;
};

window.addEventListener("load", function () {
  jiarun.onFirefoxLoad();
}, false);
