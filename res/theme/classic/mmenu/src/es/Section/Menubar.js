import $ from 'jquery';
import Component from 'Component';

const $BODY = $('body');
const $HTML = $('html');

class Scrollable {
  constructor($el) {
    this.$el = $el;
    this.native = false;
    this.api = null;

    this.init();
  }

  init() {
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

  update() {
    if (this.api) {
      this.api.update();
    }
  }

  enable() {
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

  disable() {
    if (this.api) {
      this.api.disable();
    }
  }
}

export default class extends Component {
  constructor(...args) {
    super(...args);
    this.setupMenu();
    this.$menuBody = this.$el.children('.mm-panels');
    this.scrollable = new Scrollable(this.$menuBody);

  }

  processed() {
    $HTML.removeClass('css-menubar').addClass('js-menubar');

    this.change(this.getState('menubarType'));
  }

  setupMenu() {
    if (typeof $.fn.mmenu !== 'undefined') {
      this.$el.mmenu({
        offCanvas: false,
        navbars: [{
          position: 'bottom',
          content: [
            `<div class="site-menubar-footer">
              <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip" data-original-title="Settings">
                <span class="icon wb-settings" aria-hidden="true"></span>
              </a>
              <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
                <span class="icon wb-eye-close" aria-hidden="true"></span>
              </a>
              <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
                <span class="icon wb-power" aria-hidden="true"></span>
              </a>
            </div>`
          ]
        }]
      });
    }
  }
  getDefaultState() {
    return {
      menubarType: 'unfold' // unfold, fold, open, hide;
    };
  }

  getDefaultActions() {
    return {
      menubarType: 'change'
    };
  }

  getMenuApi() {
    return this.$el.data('mmenu');
  }

  update() {
    this.scrollable.update();
  }

  change(type) {
    this.reset();
    this[type]();
  }

  animate(doing, callback = function() {}) {
    $BODY.addClass('site-menubar-changing');

    doing.call(this);

    this.$el.trigger('changing.site.menubar');

    setTimeout(() => {
      callback.call(this);
      $BODY.removeClass('site-menubar-changing');
      this.update();
      this.$el.trigger('changed.site.menubar');
    }, 500);
  }

  hoverTrigger() {
    this.$el.on('mouseenter', () => {
      $BODY.addClass('site-menubar-hover');

      setTimeout(() => {
        this.scrollable.enable();
      }, 500);

    }).on('mouseleave', () => {
      $BODY.removeClass('site-menubar-hover');

      let api = this.getMenuApi();
      if (api) {
        api.openPanel($('#mm-0'));
      }

      setTimeout(() => {
        this.scrollable.disable();
      }, 500);
    });
  }

  hoverTriggerOff() {
    this.$el.off('mouseenter');
    this.$el.off('mouseleave');
  }

  reset() {
    $BODY.removeClass('site-menubar-hide site-menubar-open site-menubar-fold site-menubar-unfold');
    $HTML.removeClass('disable-scrolling');
  }

  open() {
    this.animate(() => {
      $BODY.addClass('site-menubar-open site-menubar-unfold');

      $HTML.addClass('disable-scrolling');

    }, function() {
      this.scrollable.enable();
    });
  }

  hide() {

    this.animate(() => {
      $BODY.addClass('site-menubar-hide site-menubar-unfold');
    }, function() {
      this.scrollable.enable();
    });
  }

  unfold() {
    this.animate(function() {
      $BODY.addClass('site-menubar-unfold');
      this.hoverTriggerOff();
    }, function() {
      this.scrollable.enable();

      this.triggerResize();
    });
  }

  fold() {
    this.scrollable.disable();

    this.animate(function() {

      $BODY.addClass('site-menubar-fold');
      this.hoverTrigger();
    }, function() {
      this.triggerResize();
    });
  }
}
