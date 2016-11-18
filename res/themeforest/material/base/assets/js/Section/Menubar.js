(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define('/Section/Menubar', ['exports', 'jquery', 'Component'], factory);
  } else if (typeof exports !== "undefined") {
    factory(exports, require('jquery'), require('Component'));
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, global.jQuery, global.Component);
    global.SectionMenubar = mod.exports;
  }
})(this, function (exports, _jquery, _Component2) {
  'use strict';

  Object.defineProperty(exports, "__esModule", {
    value: true
  });

  var _jquery2 = babelHelpers.interopRequireDefault(_jquery);

  var _Component3 = babelHelpers.interopRequireDefault(_Component2);

  var $BODY = (0, _jquery2.default)('body');
  var $HTML = (0, _jquery2.default)('html');

  var Scrollable = function () {
    function Scrollable($el) {
      babelHelpers.classCallCheck(this, Scrollable);

      this.$el = $el;
      this.native = false;
      this.api = null;

      this.init();
    }

    babelHelpers.createClass(Scrollable, [{
      key: 'init',
      value: function init() {
        if ($BODY.is('.site-menubar-native')) {
          this.native = true;
          return;
        }

        this.api = this.$el.asScrollable({
          namespace: 'scrollable',
          skin: 'scrollable-inverse',
          direction: 'vertical',
          contentSelector: '>',
          containerSelector: '>'
        }).data('asScrollable');
      }
    }, {
      key: 'update',
      value: function update() {
        if (this.api) {
          this.api.update();
        }
      }
    }, {
      key: 'enable',
      value: function enable() {
        if (this.native) {
          return;
        }
        if (!this.api) {
          this.init();
        }
        if (this.api) {
          this.api.enable();
        }
      }
    }, {
      key: 'disable',
      value: function disable() {
        if (this.api) {
          this.api.disable();
        }
      }
    }]);
    return Scrollable;
  }();

  var Hoverscroll = function () {
    function Hoverscroll($el) {
      babelHelpers.classCallCheck(this, Hoverscroll);

      this.$el = $el;
      this.api = null;

      this.init();
    }

    babelHelpers.createClass(Hoverscroll, [{
      key: 'init',
      value: function init() {
        this.api = this.$el.asHoverScroll({
          namespace: 'hoverscorll',
          direction: 'vertical',
          list: '.site-menu',
          item: '> li',
          exception: '.site-menu-sub',
          fixed: false,
          boundary: 100,
          onEnter: function onEnter() {
            // $(this).siblings().removeClass('hover');
            // $(this).addClass('hover');
          },
          onLeave: function onLeave() {
            // $(this).removeClass('hover');
          }
        }).data('asHoverScroll');
      }
    }, {
      key: 'update',
      value: function update() {
        if (this.api) {
          this.api.update();
        }
      }
    }, {
      key: 'enable',
      value: function enable() {
        if (!this.api) {
          this.init();
        }
        if (this.api) {
          this.api.enable();
        }
      }
    }, {
      key: 'disable',
      value: function disable() {
        if (this.api) {
          this.api.disable();
        }
      }
    }]);
    return Hoverscroll;
  }();

  var _class = function (_Component) {
    babelHelpers.inherits(_class, _Component);

    function _class() {
      var _ref;

      babelHelpers.classCallCheck(this, _class);

      for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }

      var _this = babelHelpers.possibleConstructorReturn(this, (_ref = _class.__proto__ || Object.getPrototypeOf(_class)).call.apply(_ref, [this].concat(args)));

      _this.top = false;
      _this.folded = false;
      _this.foldAlt = false;
      _this.$menuBody = _this.$el.children('.site-menubar-body');
      _this.$menu = _this.$el.find('[data-plugin=menu]');

      (0, _jquery2.default)('.site-menu-sub').on('touchstart', function (e) {
        e.stopPropagation();
      }).on('ponitstart', function (e) {
        e.stopPropagation();
      });
      _this.scrollable = new Scrollable(_this.$menuBody);
      _this.hoverscroll = new Hoverscroll(_this.$menuBody);
      return _this;
    }

    babelHelpers.createClass(_class, [{
      key: 'processed',
      value: function processed() {
        $HTML.removeClass('css-menubar').addClass('js-menubar');

        if ($BODY.is('.site-menubar-top')) {
          this.top = true;
        }

        if ($BODY.is('.site-menubar-fold-alt')) {
          this.foldAlt = true;
        }
        this.change(this.getState('menubarType'));
      }
    }, {
      key: 'getDefaultState',
      value: function getDefaultState() {
        return {
          menubarType: 'unfold' // unfold, fold, open, hide;
        };
      }
    }, {
      key: 'getDefaultActions',
      value: function getDefaultActions() {
        return {
          menubarType: 'change'
        };
      }
    }, {
      key: 'getMenuApi',
      value: function getMenuApi() {
        return this.$menu.data('menuApi');
      }
    }, {
      key: 'setMenuData',
      value: function setMenuData() {
        var api = this.getMenuApi();

        if (api) {
          api.folded = this.folded;
          api.foldAlt = this.foldAlt;
          api.outerHeight = this.$el.outerHeight();
        }
      }
    }, {
      key: 'update',
      value: function update() {
        this.scrollable.update();
        this.hoverscroll.update();
      }
    }, {
      key: 'change',
      value: function change(type) {
        this.reset();
        this[type]();
        this.setMenuData();
      }
    }, {
      key: 'animate',
      value: function animate(doing) {
        var _this2 = this;

        var callback = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function () {};

        $BODY.addClass('site-menubar-changing');

        doing.call(this);

        this.$el.trigger('changing.site.menubar');

        var menuApi = this.getMenuApi();
        if (menuApi) {
          menuApi.refresh();
        }

        setTimeout(function () {
          callback.call(_this2);
          $BODY.removeClass('site-menubar-changing');
          _this2.update();
          _this2.$el.trigger('changed.site.menubar');
        }, 500);
      }
    }, {
      key: 'reset',
      value: function reset() {
        $BODY.removeClass('site-menubar-hide site-menubar-open site-menubar-fold site-menubar-unfold');
        $HTML.removeClass('disable-scrolling');
      }
    }, {
      key: 'open',
      value: function open() {
        this.animate(function () {
          $BODY.addClass('site-menubar-open site-menubar-unfold');

          $HTML.addClass('disable-scrolling');
        }, function () {
          this.scrollable.enable();
        });
      }
    }, {
      key: 'hide',
      value: function hide() {
        this.hoverscroll.disable();

        this.animate(function () {
          $BODY.addClass('site-menubar-hide site-menubar-unfold');
        }, function () {
          this.scrollable.enable();
        });
      }
    }, {
      key: 'unfold',
      value: function unfold() {
        this.hoverscroll.disable();

        this.animate(function () {
          $BODY.addClass('site-menubar-unfold');
          this.folded = false;
        }, function () {
          this.scrollable.enable();

          this.triggerResize();
        });
      }
    }, {
      key: 'fold',
      value: function fold() {
        this.scrollable.disable();

        this.animate(function () {

          $BODY.addClass('site-menubar-fold');
          this.folded = true;
        }, function () {
          this.hoverscroll.enable();

          this.triggerResize();
        });
      }
    }]);
    return _class;
  }(_Component3.default);

  exports.default = _class;
});
