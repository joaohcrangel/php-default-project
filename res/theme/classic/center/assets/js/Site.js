(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define('/Site', ['exports', 'jquery', 'Base', 'Menubar', 'Sidebar', 'PageAside'], factory);
  } else if (typeof exports !== "undefined") {
    factory(exports, require('jquery'), require('Base'), require('Menubar'), require('Sidebar'), require('PageAside'));
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, global.jQuery, global.Base, global.SectionMenubar, global.SectionSidebar, global.SectionPageAside);
    global.Site = mod.exports;
  }
})(this, function (exports, _jquery, _Base2, _Menubar, _Sidebar, _PageAside) {
  'use strict';

  Object.defineProperty(exports, "__esModule", {
    value: true
  });
  exports.getInstance = exports.run = exports.Site = undefined;

  var _jquery2 = babelHelpers.interopRequireDefault(_jquery);

  var _Base3 = babelHelpers.interopRequireDefault(_Base2);

  var _Menubar2 = babelHelpers.interopRequireDefault(_Menubar);

  var _Sidebar2 = babelHelpers.interopRequireDefault(_Sidebar);

  var _PageAside2 = babelHelpers.interopRequireDefault(_PageAside);

  var DOC = document;
  var $DOC = (0, _jquery2.default)(document);
  var $BODY = (0, _jquery2.default)('body');

  var Site = function (_Base) {
    babelHelpers.inherits(Site, _Base);

    function Site() {
      babelHelpers.classCallCheck(this, Site);
      return babelHelpers.possibleConstructorReturn(this, (Site.__proto__ || Object.getPrototypeOf(Site)).apply(this, arguments));
    }

    babelHelpers.createClass(Site, [{
      key: 'willProcess',
      value: function willProcess() {
        this.startLoading();
        this.initializePluginAPIs();
        this.initializePlugins();
      }
    }, {
      key: 'processed',
      value: function processed() {
        this.polyfillIEWidth();
        this.initBootstrap();

        this.setupMenubar();
        this.setupFullScreen();
        this.setupMegaNavbar();

        // Dropdown menu setup
        // ===================
        this.$el.on('click', '.dropdown-menu-media', function (e) {
          e.stopPropagation();
        });
      }
    }, {
      key: '_getDefaultMeunbarType',
      value: function _getDefaultMeunbarType() {
        if ($BODY.hasClass('site-menubar-open')) {
          return 'open';
        }
        return 'hide';
      }
    }, {
      key: 'getDefaultState',
      value: function getDefaultState() {
        var menubarType = this._getDefaultMeunbarType();
        return {
          menubarType: menubarType
        };
      }
    }, {
      key: 'getDefaultActions',
      value: function getDefaultActions() {
        return {
          menubarType: function menubarType(type) {
            var toggle = function toggle($el) {
              $el.toggleClass('hided', !(type === 'open'));
              $el.toggleClass('unfolded', !(type === 'open'));
            };

            (0, _jquery2.default)('[data-toggle="menubar"]').each(function () {
              var $this = (0, _jquery2.default)(this);
              var $hamburger = (0, _jquery2.default)(this).find('.hamburger');

              if ($hamburger.length > 0) {
                toggle($hamburger);
              } else {
                toggle($this);
              }
            });
          }
        };
      }
    }, {
      key: 'getDefaultChildren',
      value: function getDefaultChildren() {
        var menubar = new _Menubar2.default({
          $el: (0, _jquery2.default)('.site-menubar')
        });
        var sidebar = new _Sidebar2.default();
        var children = [menubar, sidebar];
        var $aside = (0, _jquery2.default)('.page-aside');
        if ($aside.length > 0) {
          children.push(new _PageAside2.default({
            $el: $aside
          }));
        }
        return children;
      }
    }, {
      key: 'getCurrentBreakpoint',
      value: function getCurrentBreakpoint() {
        var bp = Breakpoints.current();
        return bp ? bp.name : 'lg';
      }
    }, {
      key: 'initBootstrap',
      value: function initBootstrap() {
        // Tooltip setup
        // =============
        $DOC.tooltip({
          selector: '[data-tooltip=true]',
          container: 'body'
        });

        (0, _jquery2.default)('[data-toggle="tooltip"]').tooltip();
        (0, _jquery2.default)('[data-toggle="popover"]').popover();
      }
    }, {
      key: 'polyfillIEWidth',
      value: function polyfillIEWidth() {
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
          var msViewportStyle = DOC.createElement('style');
          msViewportStyle.appendChild(DOC.createTextNode('@-ms-viewport{width:auto!important}'));
          DOC.querySelector('head').appendChild(msViewportStyle);
        }
      }
    }, {
      key: 'setupFullScreen',
      value: function setupFullScreen() {
        if (typeof screenfull !== 'undefined') {
          $DOC.on('click', '[data-toggle="fullscreen"]', function () {
            if (screenfull.enabled) {
              screenfull.toggle();
            }

            return false;
          });

          if (screenfull.enabled) {
            DOC.addEventListener(screenfull.raw.fullscreenchange, function () {
              (0, _jquery2.default)('[data-toggle="fullscreen"]').toggleClass('active', screenfull.isFullscreen);
            });
          }
        }
      }
    }, {
      key: 'setupMegaNavbar',
      value: function setupMegaNavbar() {
        $DOC.on('click', '.navbar-mega .dropdown-menu', function (e) {
          e.stopPropagation();
        }).on('show.bs.dropdown', function (e) {
          var $target = (0, _jquery2.default)(e.target);
          var $trigger = e.relatedTarget ? (0, _jquery2.default)(e.relatedTarget) : $target.children('[data-toggle="dropdown"]');
          var animation = $trigger.data('animation');

          if (animation) {
            (function () {
              var $menu = $target.children('.dropdown-menu');
              $menu.addClass('animation-' + animation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $menu.removeClass('animation-' + animation);
              });
            })();
          }
        }).on('shown.bs.dropdown', function (e) {
          var $menu = (0, _jquery2.default)(e.target).find('.dropdown-menu-media > .list-group');

          if ($menu.length > 0) {
            var api = $menu.data('asScrollable');
            if (api) {
              api.update();
            } else {
              $menu.asScrollable({
                namespace: 'scrollable',
                contentSelector: '> [data-role=\'content\']',
                containerSelector: '> [data-role=\'container\']'
              });
            }
          }
        });
      }
    }, {
      key: 'setupMenubar',
      value: function setupMenubar() {
        var _this2 = this;

        (0, _jquery2.default)(document).on('click', '[data-toggle="menubar"]', function () {
          var type = _this2.getState('menubarType');
          switch (type) {
            case 'open':
              $BODY.removeClass('site-menubar-fixed');
              type = 'hide';
              break;
            case 'hide':
              $BODY.addClass('site-menubar-fixed');
              type = 'open';
              break;
            // no default
          }

          _this2.setState('menubarType', type);
          return false;
        });
      }
    }, {
      key: 'startLoading',
      value: function startLoading() {
        if (typeof _jquery2.default.fn.animsition === 'undefined') {
          return false;
        }

        // let loadingType = 'default';
        $BODY.animsition({
          inClass: 'fade-in',
          inDuration: 800,
          loading: true,
          loadingClass: 'loader-overlay',
          loadingParentElement: 'html',
          loadingInner: '\n      <div class="loader-content">\n        <img src="' + Config.get('assets') + '/images/logo@2x.png">\n        <h2>Remark</h2>\n        <div class="loader-index">\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n        </div>\n      </div>',
          onLoadEvent: true
        });
      }
    }]);
    return Site;
  }(_Base3.default);

  var instance = null;

  function getInstance() {
    if (!instance) {
      instance = new Site();
    }
    return instance;
  }

  function run() {
    var site = getInstance();
    site.run();
  }

  exports.default = Site;
  exports.Site = Site;
  exports.run = run;
  exports.getInstance = getInstance;
});
