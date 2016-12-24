(function(document, window, $) {
  'use strict';

  var Site = window.Site;

  $(document).ready(function($) {
    Site.run();
  });

  // Treeview
  // ---------
  (function() {
    // create dataset
    var data = [];
    var names = ["Lorem", "Ipsum", "Dolor", "Sit", "Amet", "Consectetur", "Adipisicing", "elit", "Eiusmod tempor", "Incididunt"];
    var endTime = Date.now();
    var month = 30 * 24 * 60 * 60 * 1000;
    var startTime = endTime - 6 * month;

    function createEvent(name, maxNbEvents) {
      maxNbEvents = maxNbEvents | 200;
      var event = {
        name: name,
        dates: []
      };
      // add up to 200 events
      var max = Math.floor(Math.random() * maxNbEvents);
      for (var j = 0; j < max; j++) {
        var time = (Math.random() * (endTime - startTime)) + startTime;
        event.dates.push(new Date(time));
      }

      return event;
    }
    for (var i = 0; i < 10; i++) {
      data.push(createEvent(names[i]));
    }

    var color = ['#62A8EA', '#57C7D4', '#46BE8A', '#56BFB5', '#ACD57C', '#F4B066', '#B98E7E', '#A3AFB7', '#BBA7E4', '#FA7A7A'];

    var init_width = $('.page-content').width() - 60;
    // create chart function
    var eventDropsChart = d3.chart.eventDrops()
      .width(init_width)
      .eventLineColor(function(datum, index) {
        return color[index];
      })
      .start(new Date(startTime))
      .end(new Date(endTime));

    // bind data with DOM
    var element = d3.select("#eventdropsExample").datum(data);

    // draw the chart
    eventDropsChart(element);

    $(window).resize(function() {
      var _width = $('.page-content').width() - 60;

      if (_width < 700) {
        return false;
      }

      eventDropsChart = d3.chart.eventDrops()
        .width(_width)
        .eventLineColor(function(datum, index) {
          return color[index];
        })
        .start(new Date(startTime))
        .end(new Date(endTime));

      eventDropsChart(element);
    });
  })();

})(document, window, jQuery);
