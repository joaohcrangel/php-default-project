init.push(function(){

  window.initSlidePanel = function($elements){

    if (!$elements) $elements = $('[data-toggle="slidePanel"]');

    var options = $.extend({}, {
      settings: {
        method: 'GET'
      },
      afterShow:function(){
        var sp = this;
        sp.$panel.find('.slidePanel-close').on('click', function(){
          sp.hide();
        });
      }
    }, PluginSlidepanel.default.getDefaults());

    $.slidePanel.setDefaults(options);

    $elements.on('click', function(){

      $.slidePanel.show({
        url:$(this).data('url')
      });
      $('.dropdown.open').removeClass('open');

    });

  };

  initSlidePanel();

});