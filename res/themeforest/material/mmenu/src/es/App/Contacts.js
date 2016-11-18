import BaseApp from 'BaseApp';

class AppContacts extends BaseApp {
  processed() {
    super.processed();
    this.$actionBtn = $('.site-action');
    this.$actionToggleBtn = this.$actionBtn.find('.site-action-toggle');
    this.$addMainForm = $('#addUserForm').modal({
      show: false
    });
    this.$content = $('#contactsContent');

    this.setupActionBtn();
    this.bindListChecked();
    this.handlSlidePanelContent();
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

  handlSlidePanelContent() {
    $(document).on('click', '[data-toggle=edit]', function() {
      let $button = $(this),
        $panel = $button.parents('.slidePanel');
      let $form = $panel.find('.user-info');

      $button.toggleClass('active');
      $form.toggleClass('active');
    });

    $(document).on('change', '.user-info .form-group', (e) => {
      let $input = $(this).find('input'),
        $span = $(this).siblings('span');
      $span.html($input.val());
    });
  }

}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppContacts();
  }

  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppContacts;
export {
  AppContacts,
  run,
  getInstance
};
