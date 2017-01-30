init.push(function(){

  window.initSlidePanel = function($elementsParents){

    if (!$elementsParents) {
      $elementsParents = $('[data-toggle="slidePanel"]');
    } else {
      $elementsParents = $elementsParents.find('[data-toggle="slidePanel"]');
    }

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

    $elementsParents.on('click', function(){

      $.slidePanel.show({
        url:$(this).data('url')
      });
      $('.dropdown.open').removeClass('open');

    });

  };

  initSlidePanel();

});