(function() {
  Ashworth = {};
  Browser = {};

  var ua = navigator.userAgent.toLowerCase();
  Browser.isWebkit = ua.indexOf('applewebkit/') > -1;
  try {
    document.createEvent("TouchEvent");
    Browser.supportsTouch = true;
  } catch (e) {
    Browser.supportsTouch = false;
  }
  Browser.isAndroid = (ua.search('android') > -1);
  var iphone = (ua.search('iphone') > -1);
  Browser.isIphone = iphone && !((ua.search('ipad') > -1) || (ua.search('ipod') > -1));
  Browser.isIpad = iphone && (ua.search('ipad') > -1);
  Browser.isIpod = iphone && (ua.search('ipod') > -1);

  Array.prototype.forEach = function(fn, obj) {
    var scope = obj || window;

    var length = this.length;
    for (var i = 0; i < length; ++i ) {
      fn.call(scope, this[i], i, this);
    }
  };

  bindEvent = function(element, name, handler) {
    if (element.addEventListener) {
      element.addEventListener(name, handler, false); 
    } else if (element.attachEvent) {
      element.attachEvent('on'+name, handler);
    }
  };

  unBindEvent = function(element, name, handler) {
    if (element.removeEventListener) {
      element.removeEventListener(name, handler); 
    } else if (element.detatchEvent) {
      element.detatchEvent('on'+name, handler);
    }
  };
})();