import Site from 'Site';

let dataTpl = () => {
  let data = {
    status: false,
    title: '',
    description: '',
    priority: 'normal',
    duedate: '',
    members: [],
    subtasks: [],
    attachments: [],
    comments: []
  };
  return data;
};

class StageList {
  constructor($el, data) {
    this.$el = $el;
    this.data = data;

    this.render();
    this.$el.sortable({
      handle: '.taskboard-stage-header'
    });
  }

  add(stage = {}) {
    if (stage instanceof Stage) {
      this.$el.append(stage.$el);
    } else {
      this.add(this.createStage(stage));
    }
  }

  createStage(data) {
    return new Stage(data);
  }

  render() {
    let length = this.data.length;
    for (let i = 0; i < length; i++) {
      let stage = this.createStage(this.data[i]);
      this.add(stage);
    }
  }
}

class Stage {
  constructor(data) {
    this.data = data;
    this.$el = null;
    this.$taskList = null;
    this.taskList = null;
    this.render();

    this.$stageDropdownArrow = $('.taskboard-stage-actions a[data-toggle="dropdown"]', this.$el);
    this.bindStageDropdownArrow();
    this.$renameBtn = $('.taskboard-stage-rename', this.$el);
    this.bindRenameBtn();
    this.$renameSaveBtn = $('.taskboard-stage-rename-save', this.$el);
    this.bindRenameSaveBtn();
    this.$deleteBtn = $('.taskboard-stage-delete', this.$el);
    this.bindDeleteBtn();
  }

  render() {
    this.$el = $(this.getTpl(this.data.title));
    this.$taskList = this.$el.find('.taskboard-list');
    let tasksData = this.data.tasks;
    this.taskList = new TaskList(this.$taskList, tasksData);
  }

  getTpl(title) {
    return `
            <li class="taskboard-stage">
              <header class="taskboard-stage-header">
                <div class="taskboard-stage-actions pull-xs-right">
                  <div class="dropdown">
                    <a data-toggle="dropdown" href="#" aria-expanded="false"><i class="icon wb-chevron-down" aria-hidden="true"></i></a>
                    <div class="dropdown-menu bullet" role="menu">
                      <a class="taskboard-stage-rename dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-pencil" aria-hidden="true"></i>Rename</a>
                      <a class="taskboard-stage-delete dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Delete</a>
                        <div class="taskboard-stage-rename-wrap">
                          <div class="form-group">
                            <input class="form-control taskboard-stage-rename-input" type="text" value="${title}" name="name">
                          </div>
                          <button class="btn btn-primary btn-block taskboard-stage-rename-save" type="button">Save</button>
                        </div>
                    </div>
                  </div>
                </div>
                <h5 class="taskboard-stage-title">${title}</h5>
              </header>
              <div class="taskboard-stage-content">
                <ul class="list-group taskboard-list"></ul>
                <div class="action-wrap">
                  <a class="add-item-toggle" href="#"><i class="icon wb-plus" aria-hidden="true"></i>Add Task</a>
                    <div class="add-item-wrap">
                      <form class="add-item" role="form" method="post" action="#">
                        <div class="form-group">
                          <label class="form-control-label m-b-15" for="name">Task name:</label>
                          <input class="form-control" type="text" placeholder="Task name" name="name">
                        </div>
                        <div class="form-group text-xs-right">
                          <a class="btn btn-sm btn-white add-item-cancel">Cancel</a>
                          <button type="button" class="btn btn-primary add-item-add">Add</button>
                        </div>
                      </form>
                    </div>
                </div>
              </div>
            </li>
           `;
  }

  bindStageDropdownArrow() {
    this.$stageDropdownArrow.on('click', function() {
      $(this).next('.dropdown-menu').removeClass('is-edit');
    });
  }

  bindRenameBtn() {
    this.$renameBtn.on('click', function(e) {
      let $header = $(this).closest('.taskboard-stage-header'),
        $menu = $(this).closest('.dropdown-menu');

      let $input = $('.taskboard-stage-rename-input', $menu),
        $title = $('.taskboard-stage-title', $header);

      $menu.toggleClass('is-edit');
      $input.val('').focus().val($title.html());
      e.stopPropagation();
    });
  }

  bindRenameSaveBtn() {
    this.$renameSaveBtn.on('click', function() {
      let $header = $(this).closest('.taskboard-stage-header'),
        $input = $('.taskboard-stage-rename-input', $header),
        $title = $('.taskboard-stage-title', $header),
        value = $input.val();

      if (value.length === 0) {
        return;
      }
      $title.html(value);
    });
  }

  bindDeleteBtn() {
    this.$deleteBtn.on('click', function() {
      let $this = $(this);
      bootbox.dialog({
        message: 'Do you want to delete the stage?',
        buttons: {
          success: {
            label: 'Delete',
            className: 'btn-danger',
            callback() {
              $this.closest('.taskboard-stage').remove();
            }
          }
        }
      });
    });
  }
}

class TaskList {
  constructor($el, data) {
    this.$el = $el;
    this.data = data;
    this.render();
    this.$el.sortable({
      connectWith: '.taskboard-stage .list-group'
    });

    this.$wrap = this.$el.parent().find('.action-wrap');
    this.$addItemToggle = this.$wrap.find('.add-item-toggle');
    this.bindAddItemToggle();
    this.$addItemBtn = this.$wrap.find('.add-item-add');
    this.bindAddItemBtn();
    this.$cancelBtn = this.$wrap.find('.add-item-cancel');
    this.bindCancelBtn();
    this.bindTaskInput();
    this.handleOpenSlidePanel();
  }

  add(task = {}) {
    if (task instanceof Task) {
      this.$el.append(task.$el);
    } else {
      let taskObj = this.createTask(task);
      taskObj.$el.data('taskInfo', task);
      this.add(taskObj);
    }
  }

  createTask(data) {
    return new Task(data);
  }

  render() {
    let length = this.data.length;
    if (length === 0) {
      return;
    }
    for (let i = 0; i < length; i++) {
      let task = this.createTask(this.data[i]);
      task.$el.data('taskInfo', this.data[i]);
      this.add(task);
    }
  }

  bindAddItemToggle() {
    this.$addItemToggle.on('click', () => {
      let $input = $('[name="name"]', this.$wrap);
      this.$wrap.toggleClass('action-open');
      $input.val('');
    });

    this.$wrap.on('click.add-item', '.form-control-label', (e) => {
      this.$wrap.removeClass('action-open');
      this.$el.off('click.add-item');
    });
  }

  bindAddItemBtn() {
    this.$addItemBtn.on('click', () => {
      let $input = $('[name="name"]', this.$wrap);
      let taskData = dataTpl();

      if ($input.val().length !== 0) {
        taskData.title = $input.val();
        this.add(taskData);
      }

      this.$wrap.toggleClass('action-open');
    });
  }

  bindCancelBtn() {
    let self = this;
    this.$cancelBtn.on('click', () => {
      self.$wrap.toggleClass('action-open');
    });
  }

  bindTaskInput() {
    this.$el.on("click", ".checkbox-custom input", function(e) {
      let $this = $(this);

      let $target = $this.closest('.list-group-item'),
        taskData = $target.data('taskInfo');

      taskData.complete = $this.prop('checked');
      $target.data('taskInfo', taskData);
      e.stopPropagation();
    });
  }

  openSlidePanel(jsonObj, showOptions) {
    if (typeof $.slidePanel === 'undefined') {
      return;
    }
    slidePanel.show(jsonObj, showOptions);
  }

  handleOpenSlidePanel() {
    let self = this;
    let options = $.extend({}, slidePanel.defaults, slidePanel.defaultsOptions);
    this.$el.on('click', '[data-taskboard="slidePanel"]', function(e) {
      let $target = $(e.target).closest('.list-group-item');
      let jsonData = {
        url: $(this).data('url'),
        target: $target
      };

      self.openSlidePanel(jsonData, options);
      e.stopPropagation();
    });
  }
}

let sildePaneldefaults = Plugin.getDefaults('slidePanel');
let sildePaneldefaultsOptions = {
  template(options) {
    return `
          <div class="${options.classes.base}  ${options.classes.base}-${options.direction}">
            <div class="${options.classes.base}-scrollable"><div>
            <div class="${options.classes.content}"></div>
            </div></div>
            <div class="${options.classes.base}-handler"></div>
          </div>
          `;
  },

  afterLoad(object) {
    let _this = this;
    let $target = $(object.target);
    let info = $target.data('taskInfo');

    this.$panel.find(`.${this.options.classes.base}-scrollable`).asScrollable({
      namespace: 'scrollable',
      contentSelector: '>',
      containerSelector: '>'
    });

    this.$panel.find('#task-description').markdown();
    if (typeof info !== 'undefined' && info.duedate.length > 0) {
      this.$panel.find('#taskDatepicker').data('date', info.duedate);
    }
    this.$panel.find('#taskDatepicker').datepicker({
      autoclose: false,
      todayHighlight: true
    }).on('changeDate', () => {
      $('#taskDatepickerInput').val(
        _this.$panel.find('#taskDatepicker').datepicker('getFormattedDate')
      );
    });

    this.$panel.data('slidePanel', object);

    $(document).off('click.slidePanelDatepicker');
    $(document).on('click.slidePanelDatepicker', 'span, td, th', (e) => {
      e.stopPropagation();
    });
  },
  afterShow() {
    let self = this;
    $(document).on('click.slidePanelShow', (e) => {
      if ($(e.target).closest('.slidePanel').length === 0 && $(e.target).closest('body').length === 1) {
        self.hide();
      }
    });
  },

  afterHide() {
    $(document).off('click.slidePanelShow');
    $(document).off('click.slidePanelDatepicker');
  },

  contentFilter(data, object) {
    let $checked = undefined,
      $panel = $(data),
      $target = $(object.target);
    let info = $target.data('taskInfo');
    let $stage = $target.closest('.taskboard-stage');
    $('.stage-name', $panel).html($('.taskboard-stage-title', $stage.html()));

    $('.task-title', $panel).html(info.title);

    switch (info.priority) {
      case 'high':
        $checked = $('#priorityHigh', $panel);
        break;
      case 'urgent':
        $checked = $('#priorityUrgent', $panel);
        break;
      default:
        $checked = $('#priorityNormal', $panel);
        break;
        // no default
    }

    $checked.prop('checked', true);
    slidePanel.handleSelective($('[data-plugin="jquery-selective"]', $panel), info.members);

    if (info.description.length === 0) {
      $('.description', $panel).addClass('is-empty');
    } else {
      $('.description-content', $panel).html(info.description);
    }

    if (info.subtasks.length !== 0) {
      let length = info.subtasks.length;
      for (let i = 0; i < length; i++) {
        let $subtask = $(slidePanel.subtaskTpl(info.subtasks[i]));
        $('.subtasks-list', $panel).append($subtask);
      }

      $('.subtasks', $panel).toggleClass('is-show');
    }

    if (info.attachments.length !== 0) {
      let length = info.attachments.length;
      for (let i = 0; i < length; i++) {
        let $attachment = $(slidePanel.attachmentTpl(info.attachments[i]));
        $('.attachments-list', $panel).append($attachment);
      }
      $('.attachments', $panel).toggleClass('is-show');
    }

    if (info.comments.length !== 0) {
      let length = info.comments.length;
      for (let i = 0; i < length; i++) {
        let $comment = $(slidePanel.commentTpl(info.comments[i].src,
          info.comments[i].user, info.comments[i].time, info.comments[i].content));
        $('.comments-history', $panel).append($comment);
      }
    }

    return $panel;
  }
};

let slidePanel = {
  defaults: sildePaneldefaults,
  defaultsOptions: sildePaneldefaultsOptions,

  handleSelective($target, selected) {
    let getSelected = function() {
      let _this = this;
      let arr = [];
      $.each(this._options.getOptions(this), (n, option) => {
        $.each(_this.options.local, (i, user) => {
          if (user.id === $(option).val()) {
            arr.push(user);
          }
        });
      });
      return arr;
    };
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
    }, {
      id: 'uid_5',
      name: 'Edward Fletcher',
      img: '../../../../global/portraits/5.jpg'
    }, {
      id: 'uid_6',
      name: 'Crystal Bates',
      img: '../../../../global/portraits/6.jpg'
    }];

    $target.selective({
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
          return `<li class="${this.namespace}-item"><img class="avatar" src="${data.img}">
            ${this.options.tpl.itemRemove.call(this)}
            </li>`;
        },
        itemRemove() {
          return `<span class="${this.namespace}-remove"><i class="wb-minus-circle"></i></span>`;
        },
        option(data) {
          return `<option value="${this.options.tpl.optionValue.call(this, data)}">${data.name}</option>`;
        }
      },

      onAfterItemAdd() {
        let $target = this.$element.closest('.slidePanel').data('slidePanel').target;
        let arr = getSelected.call(this),
          taskData = $target.data('taskInfo');
        taskData.members = arr;

        $target.data('taskInfo', taskData);
        let $memberList = $target.find('.task-members');
        let memberList = new MemberList($memberList, arr);
      },

      onAfterItemRemove() {
        let $target = this.$element.closest('.slidePanel').data('slidePanel').target;
        let arr = getSelected.call(this),
          taskData = $target.data('taskInfo');
        taskData.members = arr;

        $target.data('taskInfo', taskData);
        let $memberList = $target.find('.task-members');
        let memberList = new MemberList($memberList, arr);
      }
    });
  },

  subtaskTpl(data) {
    let checkedString = data.complete ? 'checked="checked"' : '';
    return `
            <li class="list-group-item subtask">
              <div class="checkbox-custom checkbox-primary">
                <input type="checkbox" ${checkedString} name="checkbox">
                <label class="title">${data.title}</label>
              </div>
              <div class="subtask-editor">
                <form>
                  <div class="form-group">
                    <input class="form-control subtask-title" type="text" name="title">
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary subtask-editor-save" type="button">Save</button>
                    <a class="btn btn-sm btn-white subtask-editor-delete" href="javascript:void(0)">Delete</a>
                  </div>
                </form>
              </div>
            </li>
           `;
  },

  attachmentTpl(data) {

    return `
            <li class="list-group-item">
              <div class="meida">
                <div class="media-left">
                  <div class="attachments-image">
                    <img src="${data.src}">
                  </div>
                </div>
                <div class="media-body">
                  <p><span class="name">${data.title}</span><span</p>
                  <p>
                    <span class="size">${data.size}</span>
                    <span class="attachments-actions">
                      <button class="btn btn-icon btn-pure" type="button">
                        <i class="icon wb-download" aria-hidden="true"></i>
                      </button>
                      <button class="btn btn-icon btn-pure" type="button">
                         <i class="icon wb-trash" aria-hidden="true"></i>
                      </button>
                    </span>
                  </p>
                </div>
              </div>
            </li>
           `;
  },

  commentTpl(src, user, time, content) {
    return `
            <div class="comment media">
              <div class="media-left">
                <a class="avatar avatar-lg" href="javascript:void(0)">
                  <img src="${src}" alt="...">
                </a>
              </div>
              <div class="media-body">
                <div class="comment-body">
                  <a class="comment-author" href="javascript:void(0)">${user}</a>
                  <div class="comment-meta">
                    <span class="date">${time}</span>
                  </div>
                <div class="comment-content"><p>${content}</p></div>
              </div>
            </div>
           `;
  },

  handlePriority() {

    $(document).on('click', '[name="priorities"]', function() {
      let $this = $(this);
      let $target = $this.closest('.slidePanel').data('slidePanel').target;
      let taskData = $target.data('taskInfo');
      taskData.priority = $this.data('priority');
      $target.data('taskInfo', taskData);
      $target.removeClass('priority-normal priority-high priority-urgent').addClass('priority-' + $target.data('taskInfo').priority);
    });
  },

  handleDeleteTask() {
    $(document).on('click', '.taskboard-task-delete', function() {
      let $this = $(this);
      bootbox.dialog({
        message: 'Do you want to delete the task?',
        buttons: {
          success: {
            label: 'Delete',
            className: 'btn-danger',
            callback() {
              $this.closest('.slidePanel').data('slidePanel').target.remove();
              $('.slidePanel-close').trigger('click');
            }
          }
        }
      });
    });
  },

  handleEditor() {
    $(document).on('click', '.slidePanel .task-title, .taskboard-task-edit, .description-toggle', function() {
      let $this = $(this);
      let $target = $this.closest('.slidePanel').data('slidePanel').target;
      let data = $target.data('taskInfo');

      $('#task-title').val(data.title);
      $('#task-description').val(data.description);
      $this.closest('.slidePanel').find('.task-main').addClass('is-edit');
    });

    $(document).on('click', '.task-main-editor-save', function() {
      let $this = $(this);
      let $target = $this.closest('.slidePanel').data('slidePanel').target;
      let taskData = $target.data('taskInfo');
      taskData.title = $('#task-title').val();
      taskData.description = $('#task-description').val();

      $target.data('taskInfo', taskData);
      $('.task-title', $target).html($target.data('taskInfo').title);
      $('.slidePanel .task-title').html($target.data('taskInfo').title);


      $('.slidePanel .description-content').html($target.data('taskInfo').description);

      $this.closest('.slidePanel').find('.task-main').removeClass('is-edit');
      if ($('#task-description').val().length === 0) {
        $('.description').addClass('is-empty');
      } else {
        $('.description').removeClass('is-empty');
      }
    });

    $(document).on('click', '.task-main-editor-cancel', function() {
      $(this).closest('.slidePanel').find('.task-main').removeClass('is-edit');
    });
  },

  handleSubtasks() {
    let self = this;
    $(document).on('click', '.subtask-toggle', () => {
      let length = $('.subtask').length;
      let $input = $('.subtasks-add .subtask-title'),
        $subtasks = $('.subtasks');

      $input.val('');
      if (length === 0) {
        $subtasks.addClass('is-show');
      }
      $subtasks.addClass('is-edit');

      $input.focus();

      $(document).on('click.subtask-add', (e) => {
        let $target = $(e.target);
        if ($target.closest($('.subtasks-add')).length === 0) {
          $subtasks.removeClass('is-edit');
          $(document).off('click.subtask-add');
        }
      });
    });

    $(document).on('click', '.subtask-add-save', function() {
      let $input = $('.subtasks-add .subtask-title'),
        $subtasks = $('.subtasks'),
        $target = $(this).closest('.slidePanel').data('slidePanel').target;
      let length = $('.subtask').length,
        taskData = $target.data('taskInfo'),
        value = $input.val();

      if (value.length === 0) {
        if (length === 0) {
          $subtasks.removeClass('is-show');
        }
      } else {
        let data = {
          'title': value,
          'complete': false
        };
        let $subtask = $(self.subtaskTpl(data));

        $('.subtasks-list').append($subtask);
        taskData.subtasks[length] = data;
        $target.data('taskInfo', taskData);
        let $badgeList = $target.find('.task-badges');
        let badgeList = new BadgeList($badgeList, $target.data('taskInfo'));
      }
      $input.val('').focus();
    });

    $(document).on('click', '.subtask-add-cancel', () => {
      $('.subtasks').removeClass('is-edit');
      $(document).off('click.subtask-add');
    });

    $(document).on('click', '.subtask input', function() {
      let $this = $(this);
      let $subtask = $this.closest('.subtask'),
        $target = $this.closest('.slidePanel').data('slidePanel').target;
      let index = $subtask.index(),
        taskData = $target.data('taskInfo');
      taskData.subtasks[index].complete = $this.prop('checked');
      $target.data('taskInfo', taskData);
      let $badgeList = $target.find('.task-badges');
      let badgeList = new BadgeList($badgeList, $target.data('taskInfo'));
    });

    $(document).on('click', '.subtask .title', function() {
      let $this = $(this);
      let $subtask = $this.closest('.subtask'),
        $target = $this.closest('.slidePanel').data('slidePanel').target;
      let data = $target.data('taskInfo'),
        index = $subtask.index();
      let $input = $('.subtask-title', $subtask);

      $subtask.addClass('is-edit');
      $input.val('').focus().val(data.subtasks[index].title);

      $(document).on('click.subtask', (e) => {
        let $target = $(e.target);
        if ($target.closest($subtask).length === 0) {
          $subtask.removeClass('is-edit');
          $(document).off('click.subtask');
        }
      });
    });

    $(document).on('click', '.subtask-editor-save', function() {
      let $this = $(this);

      let $subtask = $this.closest('.subtask'),
        $target = $this.closest('.slidePanel').data('slidePanel').target;

      let data = $target.data('taskInfo'),
        index = $subtask.index(),
        taskData = $target.data('taskInfo');

      taskData.subtasks[index].title = $('.subtask-title', $subtask).val();
      $target.data('taskInfo', taskData);
      $('.title', $('.subtasks-list .subtask')[index]).html($('.subtask-title', $subtask).val());
      $subtask.removeClass('is-edit');
      $(document).off('click.subtask');
    });

    $(document).on('click', '.subtask-editor-delete', function(e) {
      let $this = $(this);
      bootbox.dialog({
        message: 'Do you want to delete the subtask?',
        buttons: {
          success: {
            label: 'Delete',
            className: 'btn-danger',
            callback() {
              let $subtask = $this.closest('.subtask'),
                $target = $this.closest('.slidePanel').data('slidePanel').target;

              let data = $target.data('taskInfo'),
                index = $subtask.index(),
                taskData = $target.data('taskInfo');

              taskData.subtasks.splice(index, 1);
              $target.data('taskInfo', taskData);
              let $badgeList = $target.find('.task-badges');
              let badgeList = new BadgeList($badgeList, $target.data('taskInfo'));

              $subtask.remove();
              $(document).off('click.subtask');
              if ($('.subtask').length === 0) {
                $('.subtasks').removeClass('is-show');
              }
            }
          }
        }
      });

    });
  },

  handleDatepicker() {
    $(document).on('click', '.due-date-save', function() {
      let $this = $(this);
      let $target = $this.closest('.slidePanel').data('slidePanel').target;
      let taskData = $target.data('taskInfo'),
        value = $('#taskDatepickerInput').val();
      if (value.length > 0) {
        taskData.duedate = value;
        $target.data('taskInfo', taskData);
        let $badgeList = $target.find('.task-badges');
        let badgeList = new BadgeList($badgeList, $target.data('taskInfo'));
      }
    });

    $(document).on('click', '.due-date-delete', function() {
      let $this = $(this);
      let $target = $this.closest('.slidePanel').data('slidePanel').target;
      let taskData = $target.data('taskInfo');
      if (taskData.duedate.length === 0) {
        return;
      }
      taskData.duedate = '';
      $target.data('taskInfo', taskData);
      let $badgeList = $target.find('.task-badges');
      let badgeList = new BadgeList($badgeList, $target.data('taskInfo'));
      $('#taskDatepicker').datepicker('clearDates');
    });
  },

  handleAttachment() {
    $(document).on('click', '#fileuploadToggle', () => {
      $('#fileupload').trigger('click');
    });
  },

  show(jsonObj, showOptions) {
    $.slidePanel.show(jsonObj, showOptions);
  }
};

class Task {
  constructor(data) {
    this.$el = null;
    this.data = data;
    this.$taskBages = null;
    this.$taskMembers = null;
    this.badgeList = null;
    this.memberList = null;
    this.render(this.once);
  }

  render() {
    this.$el = $(this.getTpl(this.data));
    this.$taskBages = this.$el.find('.task-badges');
    this.badgeList = new BadgeList(this.$taskBages, this.data);
    if (this.data.members.length > 0) {
      this.$taskMembers = this.$el.find('.task-members');
      this.memberList = new MemberList(this.$taskMembers, this.data.members);
    }
  }

  getTpl(data) {
    let checkedString = data.complete ? 'checked="checked"' : '';
    return `
            <li class="list-group-item priority-${data.priority}" data-taskboard="slidePanel" data-url="panel.tpl">
              <div class="checkbox-custom checkbox-primary">
                <input type="checkbox" ${checkedString} name="checkbox">
                <label class="task-title">${data.title}</label>
              </div>
              <div class="task-badges"></div>
              <ul class="task-members">
                <li><img class="avatar avatar-sm" src="../../../../global/portraits/5.jpg"></li>
              </ul>
            </li>
           `;
  }
}

class BadgeList {
  constructor($el, data) {
    this.$el = $el;
    this.data = data;
    this.render();
  }

  add(badge) {
    this.$el.append(badge.$el);
  }

  render() {
    let {
      duedateData,
      subtasksData,
      attachmentsData,
      commentsData
    } = {
      duedateData: this.data.duedate,
      subtasksData: this.data.subtasks,
      attachmentsData: this.data.attachments,
      commentsData: this.data.comments
    };

    this.$el.children().remove();

    if (duedateData.length > 0) {
      let duedate = new Duedate(duedateData);
      this.add(duedate);
    }

    if (subtasksData.length > 0) {
      let subtasks = new Subtask(subtasksData);
      this.add(subtasks);
    }

    if (attachmentsData.length > 0) {
      let attachments = new Attachment(attachmentsData);
      this.add(attachments);
    }

    if (commentsData.length > 0) {
      let comments = new Comment(commentsData);
      this.add(comments);
    }
  }
}

class Duedate {
  constructor(data) {
    this.data = data;
    this.$el = null;
    this.render();
  }

  render() {
    this.$el = $(this.getTpl(this.data.split(/\//, 2).join('/')));
  }

  getTpl(content) {
    return `<span class="task-badge task-badge-subtask icon wb-calendar">${content}</span>`;
  }
}

class Subtask {
  constructor(data) {
    this.data = data;
    this.$el = null;
    this.render();
  }

  render() {
    let length = this.data.length;
    if (length > 0) {
      let num = 0;
      for (let i = 0; i < length; i++) {
        if (this.data[i].complete) {
          num++;
        }
      }
      this.$el = $(this.getTpl(`${num}/${length}`));
    }
  }

  getTpl(content) {
    return `<span class="task-badge task-badge-subtask icon wb-list-bulleted">${content}</span>`;
  }
}

class Attachment {
  constructor(data) {
    this.data = data;
    this.$el = null;
    this.render();
  }

  render() {
    let length = this.data.length;
    if (length > 0) {
      this.$el = $(this.getTpl(this.data.length));
    }
  }

  getTpl(content) {
    return `<span class="task-badge task-badge-attachments icon wb-paperclip">${content}</span>`;
  }
}

class Comment {
  constructor(data) {
    this.data = data;
    this.$el = null;
    this.render();
  }

  render() {
    let length = this.data.length;
    if (length > 0) {
      this.$el = $(this.getTpl(this.data.length));
    }
  }

  getTpl(content) {
    return `<span class="task-badge task-badge-comments icon wb-chat">${content}</span>`;
  }
}

class MemberList {
  constructor($el, data) {
    this.$el = $el;
    this.data = data;
    this.render();
  }

  createMember(data) {
    return new Member(data);
  }

  add(member = {}) {
    if (member instanceof Member) {
      this.$el.append(member.$el);
    } else {
      let memberObj = this.createMember(member);
      this.add(memberObj);
    }
  }

  render() {
    this.$el.children().remove();
    if (this.data.length === 0) {
      return;
    }
    let length = this.data.length;
    for (let i = 0; i < length; i++) {
      this.add(this.data[i]);
    }
  }
}

class Member {
  constructor(data) {
    this.data = data;
    this.$el = null;
    this.render();
  }

  render() {
    this.$el = $(this.getTpl(this.data.img));
  }
  getTpl(src) {
    return `<li><img class="avatar avatar-sm" src="${src}"></li>`;
  }
}

class AppTaskboard extends Site {
  processed() {
    super.processed();
    this.$taskboard = $('#taskboardStages');
    this.stageList = null;
    this.init();

    this.$floatBtn = $('.site-floataction');
    this.$model = $('#addStageFrom');
    this.$stageCreateBtn = this.$model.find('#taskboardStageCreat');

    this.bindFloatBtn();
    this.bindStageCreateBtn();

    this.handleSlidePandelAction();
  }

  init() {
    let assets = Config.get('assets');

    $.getJSON(`${assets}/data/taskboard.json`, (data) => {
      this.stageList = new StageList(this.$taskboard, data);
    });
  }

  bindFloatBtn() {
    this.$floatBtn.on('click', () => {
      $('input', this.$model).val('');
      $('option:first', $('select', this.$model)).prop('selected', 'selected');
    });
  }

  bindStageCreateBtn() {
    this.$stageCreateBtn.on('click', () => {
      let $name = $('[name="name"]', this.$model);
      let stageData = {
        title: $name.val(),
        tasks: []
      };
      this.stageList.add(stageData);
    });
  }

  handleSlidePandelAction() {
    slidePanel.handlePriority();
    slidePanel.handleSubtasks();
    slidePanel.handleDatepicker();
    slidePanel.handleEditor();
    slidePanel.handleDeleteTask();
    slidePanel.handleAttachment();
  }
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppTaskboard();
  }

  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}


export default AppTaskboard;
export {
  AppTaskboard,
  run,
  getInstance
};
