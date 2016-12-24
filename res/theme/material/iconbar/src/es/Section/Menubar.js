import $ from 'jquery';
import Component from 'Component';

const $BODY = $('body');
const $HTML = $('html');

class Hoverscroll {
  constructor($el) {
    this.$el = $el;
    this.api = null;

    this.init();
  }

  init() {
    this.api = this.$el.asHoverScroll({
      namespace: 'hoverscorll',
      direction: 'vertical',
      list: '.site-menu',
      item: '> li',
      exception: '.site-menu-sub',
      fixed: false,
      boundary: 100,
      onEnter() {
        // $(this).siblings().removeClass('hover');
        // $(this).addClass('hover');
      },
      onLeave() {
        // $(this).removeClass('hover');
      }
    }).data('asHoverScroll');
  }

  update() {
    if (this.api) {
      this.api.update();
    }
  }

  enable() {
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

    this.$menuBody = this.$el.children('.site-menubar-body');
    this.$menu = this.$el.find('[data-plugin=menu]');
    $('.site-menu-sub').on('touchstart', function(e) {
      e.stopPropagation();
    }).on('ponitstart', function(e) {
      e.stopPropagation();
    });
    this.hoverscroll = new Hoverscroll(this.$menuBody);
    this.hoverscroll.enable();
  }

  processed() {
    $HTML.removeClass('css-menubar').addClass('js-menubar');

    this.change(this.getState('menubarType'));
  }

  getDefaultState() {
    return {
      menubarType: 'open' // open, hide;
    };
  }

  getDefaultActions() {
    return {
      menubarType: 'change'
    };
  }

  getMenuApi() {
    return this.$menu.data('menuApi');
  }

  setMenuData() {
    let api = this.getMenuApi();

    api.outerHeight = this.$el.outerHeight();
  }

  update() {
    this.hoverscroll.update();
  }

  change(type) {
    this.reset();
    this[type]();
    this.setMenuData();
  }

  animate(doing, callback = function() {}) {
    $BODY.addClass('site-menubar-changing');

    doing.call(this);

    this.$el.trigger('changing.site.menubar');

    let menuApi = this.getMenuApi();
    if (menuApi) {
      menuApi.refresh();
    }

    setTimeout(() => {
      callback.call(this);
      $BODY.removeClass('site-menubar-changing');
      this.update();
      this.$el.trigger('changed.site.menubar');
    }, 500);
  }

  reset() {
    $BODY.removeClass('site-menubar-hide site-menubar-unfold');
  }

  hide() {
    this.animate(() => {
      $BODY.removeClass('site-menubar-unfold').addClass('site-menubar-hide');
    });
  }

  open() {
    this.animate(() => {
      $BODY.removeClass('site-menubar-hide').addClass('site-menubar-unfold');
    }, function() {
      this.triggerResize();
    });
  }
}
