import $ from 'jquery';
import Base from 'Base';
import {
  getDefaults
}
from 'Plugin';

// const $BODY = $('body');
// const $HTML = $('html');

export default class extends Base {
  processed() {
    if (typeof $.slidePanel === 'undefined') {
      return;
    }
    let sidebar = this;
    $(document).on('click', '[data-toggle="site-sidebar"]', function() {
      let $this = $(this);

      let direction = 'right';
      if ($('body').hasClass('site-menubar-flipped')) {
        direction = 'left';
      }

      let options = $.extend({}, getDefaults('slidePanel'), {
        direction,
        skin: 'site-sidebar',
        dragTolerance: 80,
        template(options) {
          return `<div class="${options.classes.base} ${options.classes.base}-${options.direction}">
	    <div class="${options.classes.content} site-sidebar-content"></div>
	    <div class="slidePanel-handler"></div>
	    </div>`;
        },
        afterLoad() {
          let self = this;
          this.$panel.find('.tab-pane').asScrollable({
            namespace: 'scrollable',
            contentSelector: '> div',
            containerSelector: '> div'
          });

          sidebar.initializePlugins(self.$panel);

          this.$panel.on('shown.bs.tab', () => {
            self.$panel.find('.tab-pane.active').asScrollable('update');
          });
        },
        beforeShow() {
          if (!$this.hasClass('active')) {
            $this.addClass('active');
          }
        },
        afterHide() {
          if ($this.hasClass('active')) {
            $this.removeClass('active');
          }
        }
      });

      if ($this.hasClass('active')) {
        $.slidePanel.hide();
      } else {
        let url = $this.data('url');
        if (!url) {
          url = $this.attr('href');
          url = url && url.replace(/.*(?=#[^\s]*$)/, '');
        }

        $.slidePanel.show({
          url
        }, options);
      }
    });

    $(document).on('click', '[data-toggle="show-chat"]', () => {
      $('#conversation').addClass('active');
    });

    $(document).on('click', '[data-toggle="close-chat"]', () => {
      $('#conversation').removeClass('active');
    });
  }
}
