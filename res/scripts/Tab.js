var Tab = (function(opts){

  var t = this;

  var defaults = {
    debug:false,
    activeTab:0,
    tplUl:'<ul class="nav nav-tabs nav-tabs-solid" role="tablist"></ul>',
    tpl:
      '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#{{id}}" aria-controls="{{id}}" role="tab" aria-expanded="true">{{title}}</a></li>'
  };

  var o = $.extend({}, defaults, opts);

  t.id = 0;

  t.debug = function(){

    if (o.debug === true) {
      console.info.apply(console, arguments);
    }

  };

  t.getTpl = function(html){

    return Handlebars.compile(html);

  };

  t.addListener = function(listeners, $view){

    for (var eventName in listeners) {
      $view.on(eventName, function(event){
        t.debug(eventName, event, listeners, $view);
        listeners[eventName].apply(listeners[eventName], [t, event]);
      });
    }

  };

  t.initScroll = function(){

    var $frame = t.$el;
    var $slidee = $frame.children('ul').eq(0);
    var $wrap = $frame.parent();

    // Call Sly on frame
    $frame.sly({
      horizontal: 1,
      itemNav: 'basic',
      smart: 1,
      activateOn: 'click',
      mouseDragging: 1,
      touchDragging: 1,
      releaseSwing: 1,
      startAt: 0,
      scrollBar: $wrap.find('.scrollbar'),
      scrollBy: 1,
      pagesBar: $wrap.find('.pages'),
      activatePageOn: 'click',
      speed: 300,
      elasticBounds: 1,
      easing: 'easeOutExpo',
      dragHandle: 1,
      dynamicHandle: 1,
      clickBar: 1,

      // Buttons
      forward: $wrap.find('.forward'),
      backward: $wrap.find('.backward'),
      prev: $wrap.find('.prev'),
      next: $wrap.find('.next'),
      prevPage: $wrap.find('.prevPage'),
      nextPage: $wrap.find('.nextPage')
    });

    // To Start button
    $wrap.find('.toStart').on('click', function() {
      var item = $(this).data('item');
      // Animate a particular item to the start of the frame.
      // If no item is provided, the whole content will be animated.
      $frame.sly('toStart', item);
    });

    // To Center button
    $wrap.find('.toCenter').on('click', function() {
      var item = $(this).data('item');
      // Animate a particular item to the center of the frame.
      // If no item is provided, the whole content will be animated.
      $frame.sly('toCenter', item);
    });

    // To End button
    $wrap.find('.toEnd').on('click', function() {
      var item = $(this).data('item');
      // Animate a particular item to the end of the frame.
      // If no item is provided, the whole content will be animated.
      $frame.sly('toEnd', item);
    });

    // Add item
    $wrap.find('.add').on('click', function() {
      $frame.sly('add', '<li>' + $slidee.children().length + '</li>');
    });

    // Remove item
    $wrap.find('.remove').on('click', function() {
      $frame.sly('remove', -1);
    });

  };

  t.init = function(){

    if (!o.id) o.id = "tav-"+new Date().getTime()+'-'+(++t.id);

    t.$el = $('#'+o.id);
    t.$el.data('api', t);

    if (typeof o.handler === 'function') {
      if (typeof o.listeners !== 'object') {
        o.listeners = {};
      }

      o.listeners.click = o.handler;

    }

    if (typeof o.listeners === 'object') {

      t.addListener(o.listeners, t.$el);

    }

    t.$elUl = $(t.getTpl(o.tplUl)({}));

    $.each(o.items, function(index, item){

      t.addTabElement(item);

    });

    t.$el.html(t.$elUl);

    t.$elWrap = t.$el.parent();

    t.$elWrap.css({
      'position':'relative'
    });

    t.$el.css({
      'height':'48px',
      'border-bottom':'none',
      'overflow':'hidden'
    });

    t.initScroll();

    t.$elUl.css({
      'height': '100%',
      'width':(t.$elUl.width()+2)+'px'
    });

    t.initEvents();
    t.setTabActive(o.activeTab);

  };

  t.initEvents = function(){

    t.$elUl.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      t.$elUl.find('.active').removeClass('active');
      $(e.target).addClass('active');
      t.$el.trigger({
        type:'tabchange',
        tab:e.target,
        tabContent:$($(e.target).attr('href'))[0],
        'shown.bs.tab':e
      });
    });

  };

  t.getTabsWidth = function(){

    var tabs = t.$elUl.find('li'), width = 0;

    $.each(tabs, function(){

      width += $(this).outerWidth();

    });

    return width;

  };

  t.addTabElement = function(item){

    var $li = $(t.getTpl(o.tpl)(item));

    t.$elUl.append($li);

  };

  t.setTabActive = function(index){

    var tabs = t.$elUl.find('a');

    if (tabs[index]) {
      $(tabs[index]).tab('show');
      $($(tabs[index]).attr('href')).tab('show');

    }

  };

  t.getElement = function(){

    return t.$el;

  };

  return t.init();

});