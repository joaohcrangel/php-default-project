import $ from 'jquery';
import Component from 'Component';

const $BODY = $('body');
// const $HTML = $('html');

export default class extends Component {
  constructor(...args) {
    super(...args);

    this.$scroll = this.$el.find('.page-aside-scroll');
    this.scrollable = this.$scroll.asScrollable({
      namespace: 'scrollable',
      contentSelector: '> [data-role=\'content\']',
      containerSelector: '> [data-role=\'container\']'
    }).data('asScrollable');
  }

  processed() {
    if ($BODY.is('.page-aside-fixed') || $BODY.is('.page-aside-scroll')) {
      this.$el.on('transitionend', () => {
        this.scrollable.update();
      });
    }

    Breakpoints.on('change', () => {
      let current = Breakpoints.current().name;

      if (!$BODY.is('.page-aside-fixed') && !$BODY.is('.page-aside-scroll')) {
        if (current === 'xs') {
          this.scrollable.enable();
          this.$el.on('transitionend', () => {
            this.scrollable.update();
          });
        } else {
          this.$el.off('transitionend');
          this.scrollable.update();
        }
      }
    });

    $(document).on('click.pageAsideScroll', '.page-aside-switch', () => {
      let isOpen = this.$el.hasClass('open');

      if (isOpen) {
        this.$el.removeClass('open');
      } else {
        this.scrollable.update();
        this.$el.addClass('open');
      }
    });

    $(document).on('click.pageAsideScroll', '[data-toggle="collapse"]', (e) => {
      let $trigger = $(e.target);
      if (!$trigger.is('[data-toggle="collapse"]')) {
        $trigger = $trigger.parents('[data-toggle="collapse"]');
      }
      let href;
      let target = $trigger.attr('data-target') || (href = $trigger.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '');
      let $target = $(target);

      if ($target.attr('id') === 'site-navbar-collapse') {
        this.scrollable.update();
      }
    });
  }
}
