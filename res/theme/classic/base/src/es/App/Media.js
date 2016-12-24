import BaseApp from 'BaseApp';

class AppMedia extends BaseApp {
  processed() {
    super.processed();

    this.$arrGrid = $('#arrangement-grid');
    this.$arrList = $('#arrangement-list');
    this.$actionBtn = $('.site-action');
    this.$actionToggleBtn = this.$actionBtn.find('.site-action-toggle');
    this.$content = $('#mediaContent');
    this.$fileupload = $('#fileupload');

    this.steupArrangement();
    this.setupActionBtn();
    this.bindListChecked();
    this.bindAction();
    this.bindDropdownAction();
  }

  getDefaultState() {
    return Object.assign(super.getDefaultState(), {
      list: false,
      checked: false
    });
  }

  getDefaultActions() {
    return Object.assign(super.getDefaultActions(), {
      list(active) {
        if (active) {
          this.$arrGrid.removeClass('active');
          this.$arrList.addClass('active');
          $('.media-list').removeClass('is-grid').addClass('is-list');
          $('.media-list>ul>li').removeClass('animation-scale-up').addClass('animation-fade');
        } else {
          this.$arrList.removeClass('active');
          this.$arrGrid.addClass('active');
          $('.media-list').removeClass('is-list').addClass('is-grid');
          $('.media-list>ul>li').removeClass('animation-fade').addClass('animation-scale-up');
        }
      },
      checked(checked) {
        let api = this.$actionBtn.actionBtn().data('actionBtn');
        if (checked) {
          api.show();
        } else {
          api.hide();
        }
      }
    });

  }
  steupArrangement() {
    let self = this;
    this.$arrGrid.on('click', function() {
      if ($(this).hasClass('active')) {
        return;
      }
      self.setState('list', false);
    });
    this.$arrList.on('click', function() {
      if ($(this).hasClass('active')) {
        return;
      }
      self.setState('list', true);
    });
  }

  setupActionBtn() {
    this.$actionToggleBtn.on('click', (e) => {
      if (!this.getState('checked')) {
        this.$fileupload.trigger('click');
        e.stopPropagation();
      }
    });
  }

  bindListChecked() {
    this.$content.on('asSelectable::change', (e, api, checked) => {
      this.setState('checked', checked);
    });
  }

  bindDropdownAction() {
    $('.info-wrap>.dropdown').on('show.bs.dropdown', function() {
      $(this).closest('.media-item').toggleClass('item-active');
    }).on('hidden.bs.dropdown', function() {
      $(this).closest('.media-item').toggleClass('item-active');
    });

    $('.info-wrap .dropdown-menu').on('`click', (e) => {
      e.stopPropagation();
    });
  }

  bindAction() {
    $('[data-action="trash"]', '.site-action').on('click', () => {
      console.log('trash');
    });

    $('[data-action="download"]', '.site-action').on('click', () => {
      console.log('download');
    });
  }
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppMedia();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppMedia;
export {
  AppMedia,
  run,
  getInstance
};
