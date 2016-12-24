import BaseApp from 'BaseApp';


class AppForum extends BaseApp {
  processed() {
    super.processed();

    this.handlSlidePanelPlugin();
  }

  handlSlidePanelPlugin() {
    if (typeof $.slidePanel === 'undefined') return;
    let self = this;
    let defaults = Plugin.getDefaults('slidePanel');
    let options = $.extend({}, defaults, {
      template: function(options) {
        return `<div class="${options.classes.base} ${options.classes.base}-${options.direction}">
                  <div class="${options.classes.base}-scrollable">
                    <div><div class="${options.classes.content}"></div></div>
                  </div>
                  <div class="${options.classes.base}-handler"></div>
                </div>`;
      },
      afterLoad: function() {
        this.$panel.find(`.${this.options.classes.base}-scrollable`).asScrollable({
          namespace: 'scrollable',
          contentSelector: '>',
          containerSelector: '>'
        });
      },
      afterShow: function() {
        let self = this;
        $(document).on('click.slidePanelShow', function(e) {
          if ($(e.target).closest('.slidePanel').length === 0 && $(e.target).closest('body').length === 1) {
            self.hide();
          }
        });
      },
      afterHide: function() {
        $(document).off('click.slidePanelShow');
        $(document).off('click.slidePanelDatepicker');
      }
    });

    $(document).on('click', '[data-toggle="slidePanel"]', function(e) {
      let $target = $(e.target).closest('.list-group-item');

      $.slidePanel.show({
        url: $(this).data('url'),
        target: $target
      }, options);

      e.stopPropagation();
    });
  }
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppForum();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppForum;
export {
  AppForum,
  run,
  getInstance
};
