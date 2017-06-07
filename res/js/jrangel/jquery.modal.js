$.modal = (function(){
  
  return function(_options){

    return new (function(options){

      var t = this;

      var defaults = {
        debug:false,
        modalCls:"",
        buttons:[{
          text:"Fechar",
          cls:"btn-default",
          click:function(){

            t.hide();

          }
        }],
        tplButton:Handlebars.compile(
          '<button type="button" class="btn {{cls}} waves-effect">{{text}}</button>'
        ),
        tpl:Handlebars.compile(
          '<div id="{{id}}" class="modal fade modal-fade-in-scale-up in {{modalCls}}" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" style="display: block;">'+
              '<div class="modal-dialog">'+
                '<div class="modal-content">'+
                  '<div class="modal-header">'+
                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                      '<span aria-hidden="true">×</span>'+
                    '</button>'+
                    '<h4 class="modal-title">{{title}}</h4>'+
                  '</div>'+
                  '<div class="modal-body">'+
                    
                    '{{{body}}}'+
                  '</div>'+
                  '<div class="modal-footer">'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'
        )
      };

      var o =  $.extend(defaults, options);
      o.id = o.id || "id-"+new Date().getTime();

      t.init = function () {

        o.buttonsArr = [];

        $.each(o.buttons, function (index, button) {

          var $btn = $(o.tplButton(button));

          if (button.click) {

            $btn.on("click", button.click);

          }

          o.buttonsArr.push($btn);

        });

        t.$modal = $(o.tpl(o));

        t.$modal.find(".modal-footer").append(o.buttonsArr);

        $('#'+o.id).remove();

        $("body").append(t.$modal);

      };

      t.show = function () {

        t.$modal.modal("show");

      };

      t.hide = function () {

        t.$modal.modal("hide");

      };

      t.init();

    })(_options);

  };

})();