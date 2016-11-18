import BaseApp from 'BaseApp';

class AppMailbox extends BaseApp {
  processed() {
    super.processed();

    this.$actionBtn = $('.site-action');
    this.$actionToggleBtn = this.$actionBtn.find('.site-action-toggle');
    this.$addMainForm = $('#addMailForm').modal({
      show: false
    });
    this.$content = $('#mailContent');

    this.setupActionBtn();
    this.bindListChecked();
  }

  getDefaultActions() {
    return Object.assign(super.getDefaultActions(), {
      listChecked(checked) {
        let api = this.$actionBtn.data('actionBtn');
        if (checked) {
          api.show();
        } else {
          api.hide();
        }
      }
    });
  }

  getDefaultState() {
    return Object.assign(super.getDefaultState(), {
      listChecked: false
    });
  }

  setupActionBtn() {
    this.$actionToggleBtn.on('click', (e) => {
      if (!this.getState('listChecked')) {
        this.$addMainForm.modal('show');
        e.stopPropagation();
      }
    });
  }

  bindListChecked() {
    this.$content.on('asSelectable::change', (e, api, checked) => {
      this.setState('listChecked', checked);
    });
  }
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppMailbox();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppMailbox;
export {
  AppMailbox,
  run,
  getInstance
};
