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

    // create chart function
    var eventDropsChart = d3.chart.eventDrops()
      .width(1200)
      .eventLineColor(function(datum, index) {
        return color[index];
      })
      .start(new Date(startTime))
      .end(new Date(endTime));

    // bind data with DOM
    var element = d3.select(".page-content").datum(data);

    // draw the chart
    eventDropsChart(element);
  })();

})(document, window, jQuery);
