import Site from 'Site';

class AppProjects extends Site {
  processed() {
    super.processed();

    this.handleSelective();
    this.handleProject();
  }

  handleSelective() {
    let members = [{
        id: 'uid_1',
        name: 'Herman Beck',
        img: '../../../../global/portraits/1.jpg'
      }, {
        id: 'uid_2',
        name: 'Mary Adams',
        img: '../../../../global/portraits/2.jpg'
      }, {
        id: 'uid_3',
        name: 'Caleb Richards',
        img: '../../../../global/portraits/3.jpg'
      }, {
        id: 'uid_4',
        name: 'June Lane',
        img: '../../../../global/portraits/4.jpg'
      }],
      selected = [{
        id: 'uid_1',
        name: 'Herman Beck',
        img: '../../../../global/portraits/1.jpg'
      }, {
        id: 'uid_2',
        name: 'Caleb Richards',
        img: '../../../../global/portraits/2.jpg'
      }];

    $('.plugin-selective').selective({
      namespace: 'addMember',
      local: members,
      selected,
      buildFromHtml: false,
      tpl: {
        optionValue(data) {
          return data.id;
        },
        frame() {
          return `<div class="${this.namespace}">
            ${this.options.tpl.items.call(this)}
          <div class="${this.namespace}-trigger">
            ${this.options.tpl.triggerButton.call(this)}
          <div class="${this.namespace}-trigger-dropdown">
            ${this.options.tpl.list.call(this)}
          </div>
          </div>
          </div>`;
        },
        triggerButton() {
          return `<div class="${this.namespace}-trigger-button"><i class="wb-plus"></i></div>`;
        },
        listItem(data) {
          return `<li class="${this.namespace}-list-item"><img class="avatar" src="${data.img}">${data.name}</li>`;
        },
        item(data) {
          return `<li class="${this.namespace}-item"><img class="avatar" src="${data.img}">${this.options.tpl.itemRemove.call(this)}</li>`;
        },
        itemRemove() {
          return `<span class="${this.namespace}-remove"><i class="wb-minus-circle"></i></span>`;
        },
        option(data) {
          return `<option value="${this.options.tpl.optionValue.call(this, data)}">${data.name}</option>`;
        }
      }
    });
  }

  handleProject() {
    $(document).on('click', '[data-tag=project-delete]', (e) => {
      bootbox.dialog({
        message: 'Do you want to delete the project?',
        buttons: {
          success: {
            label: 'Delete',
            className: 'btn-danger',
            callback() {
              // $(e.target).closest('.list-group-item').remove();
            }
          }
        }
      });
    });
  }
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppProjects();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppProjects;
export {
  AppProjects,
  run,
  getInstance
};
