import Plugin from 'Plugin';

const NAME = 'menu';

class Scrollable {
  constructor($el, light) {
    this.$el = $el;
    this.light = light;
    this.built = false;
    this.init();
  }
  init() {
    this.$el.asScrollable({
      namespace: 'scrollable',
      skin: '', // this.light ? '' : 'scrollable-inverse',
      direction: 'vertical',
      contentSelector: '>',
      containerSelector: '>'
    });

    this.built = true;
  }

  update($target) {
    if (typeof $target !== 'undefined') {
      $($target).data('asScrollable').update();
    } else {
      this.$el.each(function() {
        $(this).data('asScrollable').update();
      });
    }
  }

  enable() {
    this.$el.each(function() {
      $(this).data('asScrollable').enable();
    });
  }

  disable() {
    this.$el.each(function() {
      $(this).data('asScrollable').disable();
    });
  }

  refresh() {
    this.$el.each(function() {
      $(this).data('asScrollable').update();
    });
  }

  destroy() {
    this.$el.each(function() {
      $(this).data('asScrollable').disable();
    });

    this.built = false;
  }
}

class Menu extends Plugin {
  constructor(...args) {
    super(...args);

    this.$scrollItems = this.$el.find('.site-menu-scroll-wrap');

  }
  getName() {
    return NAME;
  }

  render() {
    this.bindEvents();
    this.bindResize();

    if (Breakpoints.current().name !== 'xs') {
      this.scrollable = new Scrollable(this.$scrollItems, this.options.light);
    }
    this.$el.data('menuApi', this);
  }

  globalClick(flag) {
    switch (flag) {
      case 'on':
        $(document).on('click.site.menu', (e) => {
          if ($('.dropdown > [data-dropdown-toggle="true"]').length > 0) {
            if ($(e.target).closest('.dropdown-menu').length === 0) {
              $('.dropdown > [data-dropdown-toggle="true"]').attr('data-dropdown-toggle', 'false').closest('.dropdown').removeClass('open');
            }
          }
        });
        break;
      case 'off':
        $(document).off('click.site.menu');
        break;
    }
  }

  open($tag) {
    if ($tag.is('.dropdown')) {
      $('[data-dropdown-toggle="true"]').attr('data-dropdown-toggle', 'false').closest('.dropdown').removeClass('open');
      $tag.find('>.dropdown-toggle').attr('data-dropdown-toggle', 'true');
    }
    $tag.addClass('open');
  }

  close($tag) {
    $tag.removeClass('open');
    if ($tag.is('.dropdown')) {
      $tag.find('>.dropdown-toggle').attr('data-dropdown-toggle', 'false');
    }
  }

  reset() {
    $('.dropdown > [data-dropdown-toggle="true"]').attr('data-dropdown-toggle', 'false').closest('.dropdown').removeClass('open');
  }

  bindEvents() {
    let self = this;

    if (Breakpoints.current().name !== 'xs') {
      this.globalClick('on');
    }

    this.$el.on('open.site.menu', '.site-menu-item', function(e) {
      let $item = $(this);

      if (Breakpoints.current().name === 'xs') {
        self.expand($item, () => {
          self.open($item);
        });
      } else {
        self.open($item);
      }

      if (self.options.accordion) {
        $item.siblings('.open').trigger('close.site.menu');
      }

      e.stopPropagation();
    }).on('close.site.menu', '.site-menu-item.open', function(e) {
      let $item = $(this);

      if (Breakpoints.current().name === 'xs') {
        self.collapse($item, () => {
          self.close($item);
        });
      } else {
        self.close($item);
      }

      e.stopPropagation();
    }).on('click.site.menu ', '.site-menu-item', function(e) {
      let $item = $(this);
      if ($item.is('.has-sub') && $(e.target).closest('.site-menu-item').is(this)) {
        if ($item.is('.open')) {
          $item.trigger('close.site.menu');
        } else {
          $item.trigger('open.site.menu');
        }
      }

      if (Breakpoints.current().name === 'xs') {
        e.stopPropagation();
      } else {
        if ($item.is('.dropdown')) {
          e.stopPropagation();
        }

        if ($(e.target).closest('.site-menu-scroll-wrap').length === 1) {
          self.scrollable.update($(e.target).closest('.site-menu-scroll-wrap'));
          e.stopPropagation();
        }
      }
    });
  }

  bindResize() {
    let prevBreakpoint = Breakpoints.current().name;
    Breakpoints.on('change', () => {
      let current = Breakpoints.current().name;

      this.reset();
      if (current === 'xs') {
        this.globalClick('off');
        this.scrollable.destroy();
        this.$el.off('click.site.menu.scroll');
      } else {
        if (prevBreakpoint === 'xs') {
          if (!this.scrollable) {
            this.scrollable = new Scrollable(this.$scrollItems, this.options.light);
          }
          if (!this.scrollable.built) {
            this.scrollable.init();
          }

          this.scrollable.enable();

          this.globalClick('off');
          this.globalClick('on');

          $('.site-menu .scrollable-container', this.$el).css({
            'height': '',
            'width': ''
          });

          this.$el.one('click.site.menu.scroll', '.site-menu-item', () => {
            this.scrollable.refresh();
          });
        }
      }
      prevBreakpoint = current;
    });
  }

  collapse($item, callback) {
    let self = this;
    let $sub = $($('> .site-menu-sub', $item)[0] || $('> .dropdown-menu', $item)[0] || $('> .site-menu-scroll-wrap', $item)[0]);

    $sub.show().slideUp(this.options.speed, function() {
      $(this).css('display', '');

      $(this).find('> .site-menu-item').removeClass('is-shown');

      if (callback) {
        callback();
      }

      self.$el.trigger('collapsed.site.menu');
    });
  }

  expand($item, callback) {
    let self = this;
    let $sub = $($('> .site-menu-sub', $item)[0] || $('> .dropdown-menu', $item)[0] || $('> .site-menu-scroll-wrap', $item)[0]);
    let $children = $sub.is('.site-menu-sub') ? $sub.children('.site-menu-item').addClass('is-hidden') : $($sub.find('.site-menu-sub')[0]).addClass('is-hidden');

    $sub.hide().slideDown(this.options.speed, function() {
      $(this).css('display', '');

      if (callback) {
        callback();
      }

      self.$el.trigger('expanded.site.menu');
    });

    setTimeout(() => {
      $children.addClass('is-shown');
      $children.removeClass('is-hidden');
    }, 0);
  }

  refresh() {
    this.$el.find('.open').filter(':not(.active)').removeClass('open');
  }

  static getDefaults() {
    return {
      speed: 250,
      accordion: true
    };
  }
}

Plugin.register(NAME, Menu);
