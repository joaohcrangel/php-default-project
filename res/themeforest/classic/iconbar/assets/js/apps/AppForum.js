(function (global, factory) {
  if (typeof define === "function" && define.amd) {
    define('/apps/AppForum', ['exports', 'BaseApp'], factory);
  } else if (typeof exports !== "undefined") {
    factory(exports, require('BaseApp'));
  } else {
    var mod = {
      exports: {}
    };
    factory(mod.exports, global.BaseApp);
    global.appsAppForum = mod.exports;
  }
})(this, function (exports, _BaseApp2) {
  'use strict';

  Object.defineProperty(exports, "__esModule", {
    value: true
  });
  exports.getInstance = exports.run = exports.AppForum = undefined;

  var _BaseApp3 = babelHelpers.interopRequireDefault(_BaseApp2);

  var AppForum = function (_BaseApp) {
    babelHelpers.inherits(AppForum, _BaseApp);

    function AppForum() {
      babelHelpers.classCallCheck(this, AppForum);
      return babelHelpers.possibleConstructorReturn(this, (AppForum.__proto__ || Object.getPrototypeOf(AppForum)).apply(this, arguments));
    }

    babelHelpers.createClass(AppForum, [{
      key: 'processed',
      value: function processed() {
        babelHelpers.get(AppForum.prototype.__proto__ || Object.getPrototypeOf(AppForum.prototype), 'processed', this).call(this);

        this.handlSlidePanelPlugin();
      }
    }, {
      key: 'handlSlidePanelPlugin',
      value: function handlSlidePanelPlugin() {
        if (typeof $.slidePanel === 'undefined') return;
        var self = this;
        var defaults = Plugin.getDefaults('slidePanel');
        var options = $.extend({}, defaults, {
          template: function template(options) {
            return '<div class="' + options.classes.base + ' ' + options.classes.base + '-' + options.direction + '">\n                  <div class="' + options.classes.base + '-scrollable">\n                    <div><div class="' + options.classes.content + '"></div></div>\n                  </div>\n                  <div class="' + options.classes.base + '-handler"></div>\n                </div>';
          },
          afterLoad: function afterLoad() {
            this.$panel.find('.' + this.options.classes.base + '-scrollable').asScrollable({
              namespace: 'scrollable',
              contentSelector: '>',
              containerSelector: '>'
            });
          },
          afterShow: function afterShow() {
            var self = this;
            $(document).on('click.slidePanelShow', function (e) {
              if ($(e.target).closest('.slidePanel').length === 0 && $(e.target).closest('body').length === 1) {
                self.hide();
              }
            });
          },
          afterHide: function afterHide() {
            $(document).off('click.slidePanelShow');
            $(document).off('click.slidePanelDatepicker');
          }
        });

        $(document).on('click', '[data-toggle="slidePanel"]', function (e) {
          var $target = $(e.target).closest('.list-group-item');

          $.slidePanel.show({
            url: $(this).data('url'),
            target: $target
          }, options);

          e.stopPropagation();
        });
      }
    }]);
    return AppForum;
  }(_BaseApp3.default);

  var instance = null;

  function getInstance() {
    if (!instance) {
      instance = new AppForum();
    }
    return instance;
  }

  function run() {
    var app = getInstance();
    app.run();
  }

  exports.default = AppForum;
  exports.AppForum = AppForum;
  exports.run = run;
  exports.getInstance = getInstance;
});
