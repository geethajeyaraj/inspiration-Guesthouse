/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/App.js":
/*!*****************************!*\
  !*** ./resources/js/App.js ***!
  \*****************************/
/*! exports provided: PushMenu, Treeview, Dropdown */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PushMenu__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PushMenu */ "./resources/js/PushMenu.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "PushMenu", function() { return _PushMenu__WEBPACK_IMPORTED_MODULE_0__["default"]; });

/* harmony import */ var _Treeview__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Treeview */ "./resources/js/Treeview.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "Treeview", function() { return _Treeview__WEBPACK_IMPORTED_MODULE_1__["default"]; });

/* harmony import */ var _Dropdown__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Dropdown */ "./resources/js/Dropdown.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "Dropdown", function() { return _Dropdown__WEBPACK_IMPORTED_MODULE_2__["default"]; });

//import ControlSidebar from './ControlSidebar'
//import Layout from './Layout'

 //import CardWidget from './CardWidget'
//import CardRefresh from './CardRefresh'




/***/ }),

/***/ "./resources/js/Dropdown.js":
/*!**********************************!*\
  !*** ./resources/js/Dropdown.js ***!
  \**********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * --------------------------------------------
 * AdminLTE Dropdown.js
 * License MIT
 * --------------------------------------------
 */
var Dropdown = function ($) {
  /**
   * Constants
   * ====================================================
   */
  var NAME = 'Dropdown';
  var DATA_KEY = 'lte.dropdown';
  var EVENT_KEY = ".".concat(DATA_KEY);
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var Selector = {
    DROPDOWN_MENU: 'ul.dropdown-menu',
    DROPDOWN_TOGGLE: '[data-toggle="dropdown"]'
  };
  var ClassName = {
    DROPDOWN_HOVER: '.dropdown-hover'
  };
  var Default = {};
  /**
   * Class Definition
   * ====================================================
   */

  var Dropdown =
  /*#__PURE__*/
  function () {
    function Dropdown(element, config) {
      _classCallCheck(this, Dropdown);

      this._config = config;
      this._element = element;
    } // Public


    _createClass(Dropdown, [{
      key: "toggleSubmenu",
      value: function toggleSubmenu() {
        this._element.siblings().show().toggleClass("show");

        if (!this._element.next().hasClass('show')) {
          this._element.parents('.dropdown-menu').first().find('.show').removeClass("show").hide();
        }

        this._element.parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
          $('.dropdown-submenu .show').removeClass("show").hide();
        });
      } // Static

    }], [{
      key: "_jQueryInterface",
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _config = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new Dropdown($(this), _config);
            $(this).data(DATA_KEY, data);
          }

          if (config === 'toggleSubmenu') {
            data[config]();
          }
        });
      }
    }]);

    return Dropdown;
  }();
  /**
   * Data API
   * ====================================================
   */


  $(Selector.DROPDOWN_MENU + ' ' + Selector.DROPDOWN_TOGGLE).on("click", function (event) {
    event.preventDefault();
    event.stopPropagation();

    Dropdown._jQueryInterface.call($(this), 'toggleSubmenu');
  }); // $(Selector.SIDEBAR + ' a').on('focusin', () => {
  //   $(Selector.MAIN_SIDEBAR).addClass(ClassName.SIDEBAR_FOCUSED);
  // })
  // $(Selector.SIDEBAR + ' a').on('focusout', () => {
  //   $(Selector.MAIN_SIDEBAR).removeClass(ClassName.SIDEBAR_FOCUSED);
  // })

  /**
   * jQuery API
   * ====================================================
   */

  $.fn[NAME] = Dropdown._jQueryInterface;
  $.fn[NAME].Constructor = Dropdown;

  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Dropdown._jQueryInterface;
  };

  return Dropdown;
}(jQuery);

/* harmony default export */ __webpack_exports__["default"] = (Dropdown);

/***/ }),

/***/ "./resources/js/PushMenu.js":
/*!**********************************!*\
  !*** ./resources/js/PushMenu.js ***!
  \**********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * --------------------------------------------
 * AdminLTE PushMenu.js
 * License MIT
 * --------------------------------------------
 */
var PushMenu = function ($) {
  /**
   * Constants
   * ====================================================
   */
  var NAME = 'PushMenu';
  var DATA_KEY = 'lte.pushmenu';
  var EVENT_KEY = ".".concat(DATA_KEY);
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var Event = {
    COLLAPSED: "collapsed".concat(EVENT_KEY),
    SHOWN: "shown".concat(EVENT_KEY)
  };
  var Default = {
    autoCollapseSize: false,
    enableRemember: false,
    noTransitionAfterReload: true
  };
  var Selector = {
    TOGGLE_BUTTON: '[data-widget="pushmenu"]',
    SIDEBAR_MINI: '.sidebar-mini',
    SIDEBAR_COLLAPSED: '.sidebar-collapse',
    BODY: 'body',
    OVERLAY: '#sidebar-overlay',
    WRAPPER: '.wrapper'
  };
  var ClassName = {
    SIDEBAR_OPEN: 'sidebar-open',
    COLLAPSED: 'sidebar-collapse',
    OPEN: 'sidebar-open'
  };
  /**
   * Class Definition
   * ====================================================
   */

  var PushMenu =
  /*#__PURE__*/
  function () {
    function PushMenu(element, options) {
      _classCallCheck(this, PushMenu);

      this._element = element;
      this._options = $.extend({}, Default, options);

      if (!$(Selector.BODY).hasClass(ClassName.COLLAPSED) && !$(Selector.BODY).hasClass(ClassName.OPEN)) {
        $(Selector.BODY).addClass(ClassName.OPEN);
      }

      if (!$(Selector.OVERLAY).length) {
        this._addOverlay();
      }

      this._init();
    } // Public


    _createClass(PushMenu, [{
      key: "show",
      value: function show() {
        $(Selector.BODY).addClass(ClassName.OPEN).removeClass(ClassName.COLLAPSED);

        if (this._options.enableRemember) {
          localStorage.setItem("remember".concat(EVENT_KEY), ClassName.OPEN);
        }

        var shownEvent = $.Event(Event.SHOWN);
        $(this._element).trigger(shownEvent);
      }
    }, {
      key: "collapse",
      value: function collapse() {
        $(Selector.BODY).removeClass(ClassName.OPEN).addClass(ClassName.COLLAPSED);

        if (this._options.enableRemember) {
          localStorage.setItem("remember".concat(EVENT_KEY), ClassName.COLLAPSED);
        }

        var collapsedEvent = $.Event(Event.COLLAPSED);
        $(this._element).trigger(collapsedEvent);
      }
    }, {
      key: "toggle",
      value: function toggle() {
        if ($(Selector.BODY).hasClass(ClassName.OPEN)) {
          this.collapse();
        } else {
          this.show();
        }
      }
    }, {
      key: "autoCollapse",
      value: function autoCollapse() {
        if (this._options.autoCollapseSize) {
          if ($(window).width() <= this._options.autoCollapseSize) {
            if ($(Selector.BODY).hasClass(ClassName.OPEN)) {
              this.toggle();
            }
          } else {
            if (!$(Selector.BODY).hasClass(ClassName.OPEN)) {
              this.toggle();
            }
          }
        }
      }
    }, {
      key: "remember",
      value: function remember() {
        if (this._options.enableRemember) {
          var toggleState = localStorage.getItem("remember".concat(EVENT_KEY));

          if (toggleState == ClassName.COLLAPSED) {
            if (this._options.noTransitionAfterReload) {
              $("body").addClass('hold-transition').addClass(ClassName.COLLAPSED).delay(50).queue(function () {
                $(this).removeClass('hold-transition');
                $(this).dequeue();
              });
            } else {
              $("body").addClass(ClassName.COLLAPSED);
            }
          } else {
            if (this._options.noTransitionAfterReload) {
              $("body").addClass('hold-transition').removeClass(ClassName.COLLAPSED).delay(50).queue(function () {
                $(this).removeClass('hold-transition');
                $(this).dequeue();
              });
            } else {
              $("body").removeClass(ClassName.COLLAPSED);
            }
          }
        }
      } // Private

    }, {
      key: "_init",
      value: function _init() {
        var _this = this;

        this.remember();
        this.autoCollapse();
        $(window).resize(function () {
          _this.autoCollapse();
        });
      }
    }, {
      key: "_addOverlay",
      value: function _addOverlay() {
        var _this2 = this;

        var overlay = $('<div />', {
          id: 'sidebar-overlay'
        });
        overlay.on('click', function () {
          _this2.collapse();
        });
        $(Selector.WRAPPER).append(overlay);
      } // Static

    }], [{
      key: "_jQueryInterface",
      value: function _jQueryInterface(operation) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _options = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new PushMenu(this, _options);
            $(this).data(DATA_KEY, data);
          }

          if (operation === 'toggle') {
            data[operation]();
          }
        });
      }
    }]);

    return PushMenu;
  }();
  /**
   * Data API
   * ====================================================
   */


  $(document).on('click', Selector.TOGGLE_BUTTON, function (event) {
    event.preventDefault();
    var button = event.currentTarget;

    if ($(button).data('widget') !== 'pushmenu') {
      button = $(button).closest(Selector.TOGGLE_BUTTON);
    }

    PushMenu._jQueryInterface.call($(button), 'toggle');
  });
  $(window).on('load', function () {
    PushMenu._jQueryInterface.call($(Selector.TOGGLE_BUTTON));
  });
  /**
   * jQuery API
   * ====================================================
   */

  $.fn[NAME] = PushMenu._jQueryInterface;
  $.fn[NAME].Constructor = PushMenu;

  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return PushMenu._jQueryInterface;
  };

  return PushMenu;
}(jQuery);

/* harmony default export */ __webpack_exports__["default"] = (PushMenu);

/***/ }),

/***/ "./resources/js/Treeview.js":
/*!**********************************!*\
  !*** ./resources/js/Treeview.js ***!
  \**********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * --------------------------------------------
 * AdminLTE Treeview.js
 * License MIT
 * --------------------------------------------
 */
var Treeview = function ($) {
  /**
   * Constants
   * ====================================================
   */
  var NAME = 'Treeview';
  var DATA_KEY = 'lte.treeview';
  var EVENT_KEY = ".".concat(DATA_KEY);
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var Event = {
    SELECTED: "selected".concat(EVENT_KEY),
    EXPANDED: "expanded".concat(EVENT_KEY),
    COLLAPSED: "collapsed".concat(EVENT_KEY),
    LOAD_DATA_API: "load".concat(EVENT_KEY)
  };
  var Selector = {
    LI: '.nav-item',
    LINK: '.nav-link',
    TREEVIEW_MENU: '.nav-treeview',
    OPEN: '.menu-open',
    DATA_WIDGET: '[data-widget="treeview"]'
  };
  var ClassName = {
    LI: 'nav-item',
    LINK: 'nav-link',
    TREEVIEW_MENU: 'nav-treeview',
    OPEN: 'menu-open'
  };
  var Default = {
    trigger: "".concat(Selector.DATA_WIDGET, " ").concat(Selector.LINK),
    animationSpeed: 300,
    accordion: true
  };
  /**
   * Class Definition
   * ====================================================
   */

  var Treeview =
  /*#__PURE__*/
  function () {
    function Treeview(element, config) {
      _classCallCheck(this, Treeview);

      this._config = config;
      this._element = element;
    } // Public


    _createClass(Treeview, [{
      key: "init",
      value: function init() {
        this._setupListeners();
      }
    }, {
      key: "expand",
      value: function expand(treeviewMenu, parentLi) {
        var _this = this;

        var expandedEvent = $.Event(Event.EXPANDED);

        if (this._config.accordion) {
          var openMenuLi = parentLi.siblings(Selector.OPEN).first();
          var openTreeview = openMenuLi.find(Selector.TREEVIEW_MENU).first();
          this.collapse(openTreeview, openMenuLi);
        }

        treeviewMenu.stop().slideDown(this._config.animationSpeed, function () {
          parentLi.addClass(ClassName.OPEN);
          $(_this._element).trigger(expandedEvent);
        });
      }
    }, {
      key: "collapse",
      value: function collapse(treeviewMenu, parentLi) {
        var _this2 = this;

        var collapsedEvent = $.Event(Event.COLLAPSED);
        treeviewMenu.stop().slideUp(this._config.animationSpeed, function () {
          parentLi.removeClass(ClassName.OPEN);
          $(_this2._element).trigger(collapsedEvent);
          treeviewMenu.find("".concat(Selector.OPEN, " > ").concat(Selector.TREEVIEW_MENU)).slideUp();
          treeviewMenu.find(Selector.OPEN).removeClass(ClassName.OPEN);
        });
      }
    }, {
      key: "toggle",
      value: function toggle(event) {
        var $relativeTarget = $(event.currentTarget);
        var $parent = $relativeTarget.parent();
        var treeviewMenu = $parent.find(Selector.TREEVIEW_MENU);

        if (!treeviewMenu.is(Selector.TREEVIEW_MENU)) {
          if (!$parent.is(Selector.LI)) {
            treeviewMenu = $parent.parent().find(Selector.TREEVIEW_MENU);
          }

          if (!treeviewMenu.is(Selector.TREEVIEW_MENU)) {
            return;
          }
        }

        event.preventDefault();
        var parentLi = $relativeTarget.parents(Selector.LI).first();
        var isOpen = parentLi.hasClass(ClassName.OPEN);

        if (isOpen) {
          this.collapse($(treeviewMenu), parentLi);
        } else {
          this.expand($(treeviewMenu), parentLi);
        }
      } // Private

    }, {
      key: "_setupListeners",
      value: function _setupListeners() {
        var _this3 = this;

        $(document).on('click', this._config.trigger, function (event) {
          _this3.toggle(event);
        });
      } // Static

    }], [{
      key: "_jQueryInterface",
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _config = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new Treeview($(this), _config);
            $(this).data(DATA_KEY, data);
          }

          if (config === 'init') {
            data[config]();
          }
        });
      }
    }]);

    return Treeview;
  }();
  /**
   * Data API
   * ====================================================
   */


  $(window).on(Event.LOAD_DATA_API, function () {
    $(Selector.DATA_WIDGET).each(function () {
      Treeview._jQueryInterface.call($(this), 'init');
    });
  });
  /**
   * jQuery API
   * ====================================================
   */

  $.fn[NAME] = Treeview._jQueryInterface;
  $.fn[NAME].Constructor = Treeview;

  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Treeview._jQueryInterface;
  };

  return Treeview;
}(jQuery);

/* harmony default export */ __webpack_exports__["default"] = (Treeview);

/***/ }),

/***/ "./resources/sass/App.scss":
/*!*********************************!*\
  !*** ./resources/sass/App.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/App.js ./resources/sass/App.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\projects\kareverify\resources\js\App.js */"./resources/js/App.js");
module.exports = __webpack_require__(/*! D:\projects\kareverify\resources\sass\App.scss */"./resources/sass/App.scss");


/***/ })

/******/ });