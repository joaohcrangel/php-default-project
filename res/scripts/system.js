window.System = {
  debug:false,
  inactive:new Date().getTime(),
  timerInactive:null,
  ajaxExecution:false
};
(function(document, window, $) {
  'use strict';
  var Site = window.Site;

  $(document).ready(function($) {
    
    Site.run();

    System.getApi = function(plugin, $elements, options){

      var apis = [];
      if (!options) options = {};
      var plugin = Plugin.getPlugin(plugin);

      $elements.each(function(index, element){
        var api = new plugin($(element), options);
        $(this).data('api', api);
        apis.push(api);
      });

      if (apis.length === 1) {
        return apis[0];
      } else {
        return apis;
      }

    };

    function slidePanelAfterShow(){

      var sp = this;
      sp.$panel.find('.slidePanel-close').on('click', function(){
        sp.hide();
      });

      var $content = sp.$panel.find('.slidePanel-inner');
      var h = -66;

      h += (sp.$panel.find('.slidePanel-header').outerHeight()*-1);
      h += (sp.$panel.find('.slidePanel-footer').outerHeight()*-1);

      $content.find();

      $content.wrapInner('<div data-auto-height="'+h+'"></div>');

      System.initAutoHeight($content);

    };

    System.initSlidePanel = function($elementsParents){

      if (!$elementsParents) {
        $elementsParents = $('[data-toggle="slidePanel"]');
      } else {
        $elementsParents = $elementsParents.find('[data-toggle="slidePanel"]');
      }

      var options = $.extend({}, {
        settings: {
          method: 'GET'
        },
        afterShow:slidePanelAfterShow
      }, PluginSlidepanel.default.getDefaults());

      $.slidePanel.setDefaults(options);

      $elementsParents.on('click', function(){

        $.slidePanel.show({
          url:$(this).data('url')
        });
        $('.dropdown.open').removeClass('open');

      });

    };

    System.openSlidePanel = function(_options){

      var options = $.extend({}, {
        settings: {
          method: 'GET'
        },
        afterShow:slidePanelAfterShow
      }, PluginSlidepanel.default.getDefaults());

      $.slidePanel.setDefaults(options);

      $.slidePanel.show(_options);
      
      $('.dropdown.open').removeClass('open');

    };

    System.getPanelApi = function($element){

      return System.getApi('panel', $element);

    };

    System.showError = function(r){

      $(document).trigger('page:ready');
      console.error(r);

      if (typeof r === 'string') r = {error:r};

      swal(
        "Cancelado!", 
        r.error || r.data.error || "Não foi possível executar está ação. Tente novamente mais tarde.",
        "error"
      );

    };

    System.loadHeader = function(){
      /*
      NProgress.done(true);
      NProgress.configure({
        template: '<div class="bar nprogress-bar-header" style="left:265px" role="bar"></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>'
      });
      NProgress.start();
      
      setTimeout(function(){

        System.doneHeader();

      }, 30000);
      */
    };

    System.doneHeader = function(){

      //NProgress.done(true);

    };

    System.load = function(){

      $('#mask-loader').remove();
      $('body').append('<div id="mask-loader" style="width:100%;height:100%;position:fixed;top:0;left:0;z-index:999999;text-align:center;background-color:rgba(0,0,0,.5)" class="vertical-align"><div class="loader vertical-align-middle loader-tadpole"></div></div>');

      setTimeout(function(){

        System.done();

      }, 30000);

    };

    System.done = function(){
      $('#mask-loader').fadeOut(function(){
        $(this).remove();
      });
    };

    System.alert = function(message, title, callback){

      if (!title) title = 'Atenção';

      if (typeof alertify === 'object') {
        alertify.alert(title, message, callback);
      } else {
        alert(message);
        if (typeof callback === 'function') callback();
      }

    };

    System.success = function(message, title){

      if (!title) title = 'Sucesso!';
      if (!message) message = 'Ação realizada com sucesso. :)';

      if (typeof swal === 'function') {

        swal(
          title,
          message,
          "success"
        );

      } else if (typeof alertify === 'object') {

        alertify.success(message);

      }

    };

    System.confirm = function(message, callback, title, confirmButtonText, cancelButtonText){

      if (!title) title = 'Confirmação';
      if (!callback) callback = function(){};
      if (!confirmButtonText) confirmButtonText = 'Sim';
      if (!cancelButtonText) cancelButtonText = 'Não';

      var _callback = function(_event, successFN, failureFN){

        if (typeof callback === 'function') callback(_event, successFN, failureFN);

      };

      if (typeof swal === 'function') {

        swal({
            title: title,
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#46be8a',
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {

            System.load();

            _callback(isConfirm, function(_message, _title){
              System.done();
              swal(
                _title || "Sucesso!",
                _message || "Ação realizada com sucesso. :)",
                "success"
              );
            }, function(_message, _title){
              System.done();
              swal(
                _title || "Cancelado!", 
                _message || "A ação foi cancelada.",
                "error");
            });

          });

      } else if (typeof alertify === 'object') {
        alertify.confirm(message, function(event){

          _callback(!event.cancel);

        }).set('title', title);
      } else {
        _callback(confirm(message));
      }

    };
    
    System.showLogin = function(_options){
      
      if (!_options) _options = {};
      
      var opts = $.extend({
        success:function(){},
        failure:function(r){
          System.showError(r);
        }
      }, _options);
       
      var tpl = Handlebars.compile($('#tpl-modal-login').html());
      
      var $modal = $(tpl(opts));
      
      $('#modal-login').remove();
      
      var $form = $modal.find('form');
      
      $form.form({
        url:PATH+"/users/login",
        success:function(){
          
          alertify.success("Autenticado com sucesso!");
          $modal.modal('hide');

        },
        alertError:function(error){

          alertify.error(error);

        }
      });
      
      $("body").append($modal);
      
      $modal.modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
      });
      
    };

    System.initStores = function(){

      var init = function(storeIndex, elements, callback){

        if (System.debug === true) console.log('init');

        if (storeIndex >= elements.length) {
          if (typeof callback === 'function') callback();
          return true;
        }

        var $element = $(elements[storeIndex]);

        if (System.debug === true) console.log('element', $element, $element[0].tagName);

        switch ($element[0].tagName) {

          case 'SELECT':

          $element.combobox({
            url:PATH+$element.data('url'),
            valueField:$element.data('valuefield'),
            displayField:$element.data('displayfield'),
            value:$element.data('value'),
            success:function(){
              init(++storeIndex, elements, callback);
            },
            failure:function(r){
              init(++storeIndex, elements, callback);
              System.showError(r);
            }
          });

          break;

        }

        $element.addClass('store-inited');

      };

      init(0, $('[data-plugin="select"]:not(".store-inited")'), function(){

        if (System.debug === true) console.log('stores inicializados!');

      });

    };

    System.getControllerScope = function(){

      var appElement = document.querySelector('[ng-app=app]');
      var appScope = angular.element(appElement).scope();
      return appScope.$$childHead;

    };

    System.getUser = function(){

      var controllerScope = System.getControllerScope();

      return controllerScope.User;

    };

    System.getPerson = function(){

      var controllerScope = System.getControllerScope();

      return controllerScope.User.Person;

    };

    System.setUser = function(User){

      var controllerScope = System.getControllerScope();
      
      controllerScope.$apply(function() {

        controllerScope.User = User;
        controllerScope.Person = User.Person;

      });

    };

    System.initAjaxEvents = function(){

      $(document).ajaxStart(function() {

        System.ajaxExecution = true;

      }).ajaxComplete(function() {

        System.ajaxExecution = false;

      });

    };

    System.initAutoHeight = function($elementParent){

      if (!$elementParent) $elementParent = $('body');

      $elementParent.find('[data-auto-height]').each(function(){

        var $el = $(this);

        if ($el.data('role') !== 'content') {

          $el.attr('data-role', 'content');
          $el.removeClass('overflow-auto');

          var $container = $('<div data-plugin="scrollable"><div data-role="container"></div></div>');
          
          $container.height(getPageSize().height+parseInt($el.data('auto-height')));

          $el.wrap($container);

          $el.closest('[data-plugin="scrollable"]').asScrollable(PluginAsscrollable.default.getDefaults());

        } else {

          $el.closest('[data-plugin="scrollable"]').height(getPageSize().height+parseInt($el.data('auto-height')));
          $el.closest('[data-plugin="scrollable"]').asScrollable("update");

        }

      });

    };

    System.initAjaxEvents();

    $(window).on('load', function(){
      System.initStores();
      System.initAutoHeight();
    }).on('resize', function(){
      System.initAutoHeight();
    });

    $(document).on('page:loading', function(){
      System.loadHeader();
    }).on('page:ready', function(){
      System.doneHeader();
    });

    if (init instanceof Array) {

      $.each(init, function(index, fn){

        if (typeof fn === 'function') {
          fn();
        }

      });

    }

  });
})(document, window, jQuery);