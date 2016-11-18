import Site from 'Site';

class AppNotebook extends Site {
  processed() {
    super.processed();

    this.$listItem = $('.list-group-item');
    this.$actionBtn = $('.site-action');
    this.$toggle = this.$actionBtn.find('.site-action-toggle');
    this.$newNote = $('#addNewNote');
    this.$mdEdit = $('#mdEdit');
    this.window = $(window);

    this.handleResize();
    this.steupListItem();
    this.steupActionBtn();
  }

  initEditer() {
    this.$mdEdit.markdown({
      autofocus: false,
      savable: false
    });
  }

  getDefaultState() {
    return Object.assign(super.getDefaultState(), {
      listItemActive: false
    });
  }

  getDefaultActions() {
    return Object.assign(super.getDefaultActions(), {
      listItemActive(active) {
        let api = this.$actionBtn.data('actionBtn');
        if (active) {
          api.show();
        } else {
          this.$listItem.removeClass('active');
        }
      }
    });
  }

  steupListItem() {
    let self = this;
    this.$listItem.on('click', function() {
      $(this).siblings().removeClass('active');
      $(this).addClass('active');

      self.setState('listItemActive', true);
    });
  }

  steupActionBtn() {
    this.$toggle.on('click', (e) => {
      if (this.getState('listItemActive')) {
        this.setState('listItemActive', false);
      } else {
        this.$newNote.modal('show');
        e.stopPropagation();
      }
    });
  }

  handleResize() {
    this.window.on('resize', this.initEditer());
  }
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppNotebook();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppNotebook;
export {
  AppNotebook,
  run,
  getInstance
};
