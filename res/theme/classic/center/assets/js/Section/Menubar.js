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
      _this.scrollable = new Scrollable(_this.$menuBody);

      if ($BODY.hasClass('site-menubar-fold')) {
        _this.isFold = true;
      } else {
        _this.isFold = false;
      }

      if (!_this.isFold) {
        _this.bindHover();
      }
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
          menubarType: 'hide' // open, hide;
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
      key: 'bindHover',
      value: function bindHover() {
        var _this2 = this;

        this.$el.on('mouseenter', function () {
          if ($BODY.hasClass('site-menubar-fixed') || $BODY.hasClass('site-menubar-disable-hover') || $BODY.hasClass('site-menubar-changing')) {
            return;
          }
          _this2.setState('menubarType', 'open');
        }).on('mouseleave', function () {
          if ($BODY.hasClass('site-menubar-fixed') || $BODY.hasClass('site-menubar-disable-hover')) {
            return;
          }
          _this2.setState('menubarType', 'hide');
        });
      }
    }, {
      key: 'setMenuData',
      value: function setMenuData() {
        var api = this.getMenuApi();

        api.folded = !(this.getState('menubarType') === 'open') && this.isFold;
        api.foldAlt = false;
        api.outerHeight = this.$el.outerHeight();
      }
    }, {
      key: 'getMenuApi',
      value: function getMenuApi() {
        return this.$menu.data('menuApi');
      }
    }, {
      key: 'update',
      value: function update() {
        this.scrollable.update();
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
        var _this3 = this;

        var callback = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : function () {};

        $BODY.addClass('site-menubar-changing');

        setTimeout(function () {
          doing.call(_this3);
          _this3.$el.trigger('changing.site.menubar');
          var menuApi = _this3.getMenuApi();
          if (menuApi) {
            menuApi.refresh();
          }
        }, 10);

        setTimeout(function () {
          callback.call(_this3);
          $BODY.removeClass('site-menubar-changing');
          _this3.update();
          _this3.$el.trigger('changed.site.menubar');
        }, 250);
      }
    }, {
      key: 'reset',
      value: function reset() {
        $BODY.removeClass('site-menubar-hide site-menubar-open');
      }
    }, {
      key: 'open',
      value: function open() {
        this.animate(function () {
          $BODY.addClass('site-menubar-open');
        }, function () {
          this.scrollable.enable();
          this.triggerResize();
        });
      }
    }, {
      key: 'hide',
      value: function hide() {
        this.scrollable.disable();
        this.animate(function () {
          $BODY.addClass('site-menubar-hide');
        }, function () {
          this.triggerResize();
        });
      }
    }, {
      key: 'update',
      value: function update() {
        this.scrollable.update();
      }
    }]);
    return _class;
  }(_Component3.default);

  exports.default = _class;
});
