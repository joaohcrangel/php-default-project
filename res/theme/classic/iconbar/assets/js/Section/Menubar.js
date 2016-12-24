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

      _this.$menuBody = _this.$el.children('.site-menubar-body');
      _this.$menu = _this.$el.find('[data-plugin=menu]');
      (0, _jquery2.default)('.site-menu-sub').on('touchstart', function (e) {
        e.stopPropagation();
      }).on('ponitstart', function (e) {
        e.stopPropagation();
      });
      _this.hoverscroll = new Hoverscroll(_this.$menuBody);
      _this.hoverscroll.enable();
      return _this;
    }

    babelHelpers.createClass(_class, [{
      key: 'processed',
      value: function processed() {
        $HTML.removeClass('css-menubar').addClass('js-menubar');

        this.change(this.getState('menubarType'));
      }
    }, {
      key: 'getDefaultState',
      value: function getDefaultState() {
        return {
          menubarType: 'open' // open, hide;
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

        api.outerHeight = this.$el.outerHeight();
      }
    }, {
      key: 'update',
      value: function update() {
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
        $BODY.removeClass('site-menubar-hide site-menubar-unfold');
      }
    }, {
      key: 'hide',
      value: function hide() {
        this.animate(function () {
          $BODY.removeClass('site-menubar-unfold').addClass('site-menubar-hide');
        });
      }
    }, {
      key: 'open',
      value: function open() {
        this.animate(function () {
          $BODY.removeClass('site-menubar-hide').addClass('site-menubar-unfold');
        }, function () {
          this.triggerResize();
        });
      }
    }]);
    return _class;
  }(_Component3.default);

  exports.default = _class;
});
