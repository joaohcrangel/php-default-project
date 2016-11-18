import BaseApp from 'BaseApp';

class AppWork extends BaseApp {
  processed() {
    super.processed();

    this.items = [];

    this.handleChart();
    this.handleSelective();
  }

  handleChart() {
    /* create line chart */
    let scoreChart = (data) => {

      let scoreChart = new Chartist.Line(data, {
        labels: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
        series: [{
          name: 'series-1',
          data: [0.8, 1.5, 0.8, 2.7, 2.4, 3.9, 1.1]
        }, {
          name: 'series-2',
          data: [2.2, 3, 2.7, 3.6, 1.5, 1, 2.9]
        }]
      }, {
        lineSmooth: Chartist.Interpolation.simple({
          divisor: 100
        }),
        fullWidth: true,
        chartPadding: {
          right: 25
        },
        series: {
          'series-1': {
            showArea: false
          },
          'series-2': {
            showArea: false
          }
        },
        axisX: {
          showGrid: false
        },
        axisY: {
          scaleMinSpace: 40
        },
        plugins: [
          Chartist.plugins.tooltip()
        ],
        low: 0,
        height: 250
      });

      scoreChart.on('draw', (data) => {
        if (data.type === 'point') {
          let parent = new Chartist.Svg(data.element._node.parentNode);
          parent.elem('line', {
            x1: data.x,
            y1: data.y,
            x2: data.x + 0.01,
            y2: data.y,
            class: 'ct-point-content'
          });
        }
      });
    };

    // let WeekLabelList = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
    // let WeekSeries1List = {
    //   name: 'series-1',
    //   data: [0.8, 1.5, 0.8, 2.7, 2.4, 3.9, 1.1]
    // };
    // let WeekSeries2List = {
    //   name: 'series-2',
    //   data: [2.2, 3, 2.7, 3.6, 1.5, 1, 2.9]
    // };

    /* create bar chart */
    let barChart = (data) => {
      let barChart = new Chartist.Bar(data, {
        labels: ['Damon', 'Jimmy', 'Jhon', 'Alex', 'Lucy', 'Peter', 'Chris'],
        series: [
          [3.3, 3.5, 2.5, 2, 3.7, 2.7, 1.9],
          [2, 4, 3.5, 2.7, 3.3, 3.5, 2.5]
        ]
      }, {
        axisX: {
          showGrid: false
        },
        axisY: {
          showGrid: false,
          scaleMinSpace: 30
        },
        height: 210,
        seriesBarDistance: 24
      });

      barChart.on('draw', (data) => {
        if (data.type === 'bar') {
          let parent = new Chartist.Svg(data.element._node.parentNode);
          parent.elem('line', {
            x1: data.x1,
            x2: data.x2,
            y1: data.y2,
            y2: 0,
            class: 'ct-bar-fill'
          });

          data.element.attr({
            style: 'stroke-width: 20px'
          });
        }
      });
    };

    /* run chart */
    $(document).on('slidePanel::afterLoad', () => {
      scoreChart('.trends-chart');
      barChart('.member-chart');
    });
  }

  handleSelective() {
    let self = this;
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
    }, {
      id: 'uid_5',
      name: 'June Lane',
      avatar: '../../../../global/portraits/5.jpg'
    }, {
      id: 'uid_6',
      name: 'June Lane',
      avatar: '../../../../global/portraits/6.jpg'
    }, {
      id: 'uid_7',
      name: 'June Lane',
      avatar: '../../../../global/portraits/7.jpg'
    }];

    let getNum = (num) => {
      return Math.ceil(Math.random() * (num + 1));
    };

    let getMember = () => {
      return member[getNum(member.length - 1) - 1];
    };

    let isSame = (items) => {
      let _items = items;
      let _member = getMember();

      if (_items.indexOf(_member) === -1) {
        return _member;
      }
      return isSame(_items);
    };

    let pushMember = (num) => {
      let items = [];
      for (let i = 0; i < num; i++) {
        items.push(isSame(items));
      }
      this.items = items;
    };

    let setItems = (membersNum) => {
      let num = getNum(membersNum - 1);
      pushMember(num);
    };

    $('.plugin-selective').each(function() {

      setItems(member.length);

      let items = self.items;

      $(this).selective({
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

            // i++;
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
    });
  }
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppWork();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppWork;
export {
  AppWork,
  run,
  getInstance
};
