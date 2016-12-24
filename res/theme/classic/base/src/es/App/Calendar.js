import Site from 'Site';
import * as Config from 'Config';

class AppCalendar extends Site {
  processed() {
    super.processed();

    this.$actionToggleBtn = $('.site-action-toggle');
    this.$addNewCalendarForm = $('#addNewCalendar').modal({
      show: false
    });

    this.handleFullcalendar();
    this.handleSelective();
    this.handleAction();
    this.handleListItem();
    this.handleEventList();
  }

  handleFullcalendar() {
    let myEvents = [{
      title: 'All Day Event',
      start: '2016-10-01'
    }, {
      title: 'Long Event',
      start: '2016-10-07',
      end: '2016-10-10',
      backgroundColor: Config.colors('cyan', 600),
      borderColor: Config.colors('cyan', 600)
    }, {
      id: 999,
      title: 'Repeating Event',
      start: '2016-10-09T16:00:00',
      backgroundColor: Config.colors('red', 600),
      borderColor: Config.colors('red', 600)
    }, {
      title: 'Conference',
      start: '2016-10-11',
      end: '2016-10-13'
    }, {
      title: 'Meeting',
      start: '2016-10-12T10:30:00',
      end: '2016-10-12T12:30:00'
    }, {
      title: 'Lunch',
      start: '2016-10-12T12:00:00'
    }, {
      title: 'Meeting',
      start: '2016-10-12T14:30:00'
    }, {
      title: 'Happy Hour',
      start: '2016-10-12T17:30:00'
    }, {
      title: 'Dinner',
      start: '2016-10-12T20:00:00'
    }, {
      title: 'Birthday Party',
      start: '2016-10-13T07:00:00'
    }];

    let myOptions = {
      header: {
        left: null,
        center: 'prev,title,next',
        right: 'month,agendaWeek,agendaDay'
      },
      defaultDate: '2016-10-12',
      selectable: true,
      selectHelper: true,
      select() {
        $('#addNewEvent').modal('show');
      },
      editable: true,
      eventLimit: true,
      windowResize(view) {
        let width = $(window).outerWidth();
        let options = Object.assign({}, myOptions);
        options.events = view.calendar.getEventCache();
        options.aspectRatio = width < 667 ? 0.5 : 1.35;

        $('#calendar').fullCalendar('destroy');
        $('#calendar').fullCalendar(options);
      },
      eventClick(event) {
        let color = event.backgroundColor ? event.backgroundColor : Config.colors('blue', 600);
        $('#editEname').val(event.title);

        if (event.start) {
          $('#editStarts').datepicker('update', event.start._d);
        } else {
          $('#editStarts').datepicker('update', '');
        }
        if (event.end) {
          $('#editEnds').datepicker('update', event.end._d);
        } else {
          $('#editEnds').datepicker('update', '');
        }

        $('#editColor [type=radio]').each(function() {
          let $this = $(this),
            _value = $this.data('color').split('|'),
            value = Config.colors(_value[0], _value[1]);
          if (value === color) {
            $this.prop('checked', true);
          } else {
            $this.prop('checked', false);
          }
        });

        $('#editNewEvent').modal('show').one('hidden.bs.modal', (e) => {
          event.title = $('#editEname').val();

          let color = $('#editColor [type=radio]:checked').data('color').split('|');
          color = Config.colors(color[0], color[1]);
          event.backgroundColor = color;
          event.borderColor = color;

          event.start = new Date($('#editStarts').data('datepicker').getDate());
          event.end = new Date($('#editEnds').data('datepicker').getDate());
          $('#calendar').fullCalendar('updateEvent', event);
        });
      },
      eventDragStart() {
        $('.site-action').data('actionBtn').show();
      },
      eventDragStop() {
        $('.site-action').data('actionBtn').hide();
      },
      events: myEvents,
      droppable: true
    };

    let _options;
    let myOptionsMobile = Object.assign({}, myOptions);

    myOptionsMobile.aspectRatio = 0.5;
    _options = $(window).outerWidth() < 667 ? myOptionsMobile : myOptions;

    $('#editNewEvent').modal();
    $('#calendar').fullCalendar(_options);
  }

  handleSelective() {

    let member = [{
      id: 'uid_1',
      name: 'Herman Beck',
      avatar: '../../../../global/portraits/1.jpg'
    }, {
      id: 'uid_2',
      name: 'Mary Adams',
      avatar: '../../../../global/portraits/2.jpg'
    }, {
      id: 'uid_3',
      name: 'Caleb Richards',
      avatar: '../../../../global/portraits/3.jpg'
    }, {
      id: 'uid_4',
      name: 'June Lane',
      avatar: '../../../../global/portraits/4.jpg'
    }];

    let items = [{
      id: 'uid_1',
      name: 'Herman Beck',
      avatar: '../../../../global/portraits/1.jpg'
    }, {
      id: 'uid_2',
      name: 'Caleb Richards',
      avatar: '../../../../global/portraits/2.jpg'
    }];

    $('.plugin-selective').selective({
      namespace: 'addMember',
      local: member,
      selected: items,
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
          return `<li class="${this.namespace}-list-item"><img class="avatar" src="${data.avatar}">${data.name}</li>`;
        },
        item(data) {
          return `<li class="${this.namespace}-item"><img class="avatar" src="${data.avatar}" title="${data.name}">${this.options.tpl.itemRemove.call(this)}</li>`;
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

  handleAction() {
    this.$actionToggleBtn.on('click', (e) => {
      this.$addNewCalendarForm.modal('show');
      e.stopPropagation();
    });
  }

  handleEventList() {
    $('#addNewEventBtn').on('click', () => {
      $('#addNewEvent').modal('show');
    });

    $('.calendar-list .calendar-event').each(function() {
      let $this = $(this),
        color = $this.data('color').split('-');
      $this.data('event', {
        title: $this.data('title'),
        stick: $this.data('stick'),
        backgroundColor: Config.colors(color[0], color[1]),
        borderColor: Config.colors(color[0], color[1])
      });
      $this.draggable({
        zIndex: 999,
        revert: true,
        revertDuration: 0,
        appendTo: '.page',
        helper() {
          return `<a class="fc-day-grid-event fc-event fc-start fc-end" style="background-color:${Config.colors(color[0], color[1])};border-color:${Config.colors(color[0], color[1])}">
          <div class="fc-content">
            <span class="fc-title">${$this.data('title')}</span>
          </div>
          </a>`;
        }
      });
    });
  }

  handleListItem() {
    this.$actionToggleBtn.on('click', (e) => {
      $('#addNewCalendar').modal('show');
      e.stopPropagation();
    });

    $(document).on('click', '[data-tag=list-delete]', (e) => {
      bootbox.dialog({
        message: 'Do you want to delete the calendar?',
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
    instance = new AppCalendar();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppCalendar;
export {
  AppCalendar,
  run,
  getInstance
};
