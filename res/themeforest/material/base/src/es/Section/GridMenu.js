import $ from 'jquery';
import Component from 'Component';

const $BODY = $('body');
const $HTML = $('html');

class Scrollable {
  constructor($el) {
    this.$el = $el;
    this.api = null;

    this.init();
  }

  init() {
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

    this.scrollable = new Scrollable(this.$el);
  }

  getDefaultState() {
    return {
      gridmenu: false // false = not open, true = open;
    };
  }

  getDefaultActions() {
    return {
      gridmenu: 'toggle'
    };
  }

  open() {
    this.animate(function() {
      this.$el.addClass('active');

      $('[data-toggle="gridmenu"]').addClass('active')
        .attr('aria-expanded', true);

      $BODY.addClass('site-gridmenu-active');
      $HTML.addClass('disable-scrolling');
    }, function() {
      this.scrollable.enable();
    });
  }

  close() {
    this.animate(function() {

      this.$el.removeClass('active');

      $('[data-toggle="gridmenu"]').addClass('active')
        .attr('aria-expanded', true);

      $BODY.removeClass('site-gridmenu-active');
      $HTML.removeClass('disable-scrolling');
    }, function() {
      this.scrollable.disable();
    });
  }

  toggle(opened) {
    if (opened) {
      this.open();
    } else {
      this.close();
    }
  }

  animate(doing, callback) {
    doing.call(this);
    this.$el.trigger('changing.site.gridmenu');

    setTimeout(() => {
      callback.call(this);

      this.$el.trigger('changed.site.gridmenu');
    }, 500);
  }
}
