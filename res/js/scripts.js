
var Button=function(n){var t=this,e={debug:!0,tpl:'<button type="button" class="btn btn-md {{cls}} waves-effect" style="border-radius: 0"><i class="icon {{icon}}" aria-hidden="true"></i><br><span class="text-uppercase hidden-sm-down">{{text}}</span></button>'},o=$.extend({},e,n);return t.$el="",t.debug=function(){o.debug===!0&&console.info.apply(console,arguments)},t.getTpl=function(n){return Handlebars.compile(n)},t.setLoad=function(n){return t.$el.btnload(n===!0?"load":"unload")},t.setDisabled=function(n){return t.$el.prop("disabled",n)},t.addListener=function(n,e){for(var o in n)e.on(o,function(i){t.debug(o,i,n,e),n[o].apply(n[o],[t,i])})},t.init=function(){t.$el=$(t.getTpl(o.tpl)(o)),"function"==typeof o.handler&&("object"!=typeof o.listeners&&(o.listeners={}),o.listeners.click=o.handler),"object"==typeof o.listeners&&t.addListener(o.listeners,t.$el)},t.getElement=function(){return t.$el},t.init()},ActionButton=function(n){var t=this,e={debug:!0,buttons:[],tplBtn:'<button type="button" class="btn btn-md {{cls}} waves-effect" style="border-radius: 0"><i class="icon {{icon}}" aria-hidden="true"></i><br><span class="text-uppercase hidden-sm-down">{{text}}</span></button>'},o=$.extend({},e,n),i=$("#"+o.id);t.debug=function(){o.debug===!0&&console.info.apply(console,arguments)},t.addButtons=function(n){$.each(n,function(n,e){t.addButton(e)})},t.getTpl=function(n){return Handlebars.compile(n)},t.addButton=function(n){var e=new Button(n),o=e.getElement();t.debug(n,o),i.append(o)},t.addListener=function(n,e){for(var o in n)e.on(o,function(i){t.debug(o,i,n,e),n[o].apply(n[o],[i])})},t.init=function(){i.html(""),t.addButtons(o.buttons)},t.init()};

function abbrNum(e,t){t=Math.pow(10,t);for(var n=["k","m","b","t"],o=n.length-1;o>=0;o--){var i=Math.pow(10,3*(o+1));if(i<=e){e=Math.round(e*t/i)/t,1e3==e&&o<n.length-1&&(e=1,o++),e+=n[o];break}}return e}function getPageSize(){var e,t;return self.innerHeight?(e=self.innerWidth,t=self.innerHeight):document.documentElement&&document.documentElement.clientHeight?(e=document.documentElement.clientWidth,t=document.documentElement.clientHeight):document.body&&(e=document.body.clientWidth,t=document.body.clientHeight),{width:e,height:t}}function searchToObject(){var e,t,n=window.location.search.substring(1).split("&"),o={};for(t in n)""!==n[t]&&(e=n[t].split("="),o[decodeURIComponent(e[0])]=decodeURIComponent(e[1]));return o}

init.push(function(){System.initSlidePanel()});

window.System={debug:!1,inactive:(new Date).getTime(),timerInactive:null,ajaxExecution:!1},function(e,t,o){"use strict";var n=t.Site;o(e).ready(function(o){n.run(),System.getApi=function(e,t,n){var a=[];n||(n={});var e=Plugin.getPlugin(e);return t.each(function(t,i){var s=new e(o(i),n);o(this).data("api",s),a.push(s)}),1===a.length?a[0]:a},System.initSlidePanel=function(e){e=e?e.find('[data-toggle="slidePanel"]'):o('[data-toggle="slidePanel"]');var t=o.extend({},{settings:{method:"GET"},afterShow:function(){var e=this;e.$panel.find(".slidePanel-close").on("click",function(){e.hide()})}},PluginSlidepanel.default.getDefaults());o.slidePanel.setDefaults(t),e.on("click",function(){o.slidePanel.show({url:o(this).data("url")}),o(".dropdown.open").removeClass("open")})},System.getPanelApi=function(e){return System.getApi("panel",e)},System.showError=function(t){o(e).trigger("page:ready"),console.error(t),"string"==typeof t&&(t={error:t}),swal("Cancelado!",t.error||t.data.error||"Não foi possível executar está ação. Tente novamente mais tarde.","error")},System.loadHeader=function(){},System.doneHeader=function(){},System.load=function(){o("#mask-loader").remove(),o("body").append('<div id="mask-loader" style="width:100%;height:100%;position:fixed;top:0;left:0;z-index:999999;text-align:center;background-color:rgba(0,0,0,.5)" class="vertical-align"><div class="loader vertical-align-middle loader-tadpole"></div></div>'),setTimeout(function(){System.done()},3e4)},System.done=function(){o("#mask-loader").fadeOut(function(){o(this).remove()})},System.alert=function(e,t,o){t||(t="Atenção"),"object"==typeof alertify?alertify.alert(t,e,o):(alert(e),"function"==typeof o&&o())},System.success=function(e,t){t||(t="Sucesso!"),e||(e="Ação realizada com sucesso. :)"),"function"==typeof swal?swal(t,e,"success"):"object"==typeof alertify&&alertify.success(e)},System.confirm=function(e,t,o,n,a){o||(o="Confirmação"),t||(t=function(){}),n||(n="Sim"),a||(a="Não");var i=function(e,o,n){"function"==typeof t&&t(e,o,n)};"function"==typeof swal?swal({title:o,text:e,type:"warning",showCancelButton:!0,confirmButtonColor:"#46be8a",confirmButtonText:n,cancelButtonText:a,closeOnConfirm:!1,closeOnCancel:!1},function(e){System.load(),i(e,function(e,t){System.done(),swal(t||"Sucesso!",e||"Ação realizada com sucesso. :)","success")},function(e,t){System.done(),swal(t||"Cancelado!",e||"A ação foi cancelada.","error")})}):"object"==typeof alertify?alertify.confirm(e,function(e){i(!e.cancel)}).set("title",o):i(confirm(e))},System.showLogin=function(e){e||(e={});var t=o.extend({success:function(){},failure:function(e){System.showError(e)}},e),n=Handlebars.compile(o("#tpl-modal-login").html()),a=o(n(t));o("#modal-login").remove();var i=a.find("form");i.form({url:PATH+"/usuarios/login",success:function(){alertify.success("Autenticado com sucesso!"),a.modal("hide")},alertError:function(e){alertify.error(e)}}),o("body").append(a),a.modal({show:!0,keyboard:!1,backdrop:"static"})},System.initStores=function(){var e=function(t,n,a){if(System.debug===!0&&console.log("init"),t>=n.length)return"function"==typeof a&&a(),!0;var i=o(n[t]);switch(System.debug===!0&&console.log("element",i,i[0].tagName),i[0].tagName){case"SELECT":i.combobox({url:PATH+i.data("url"),valueField:i.data("valuefield"),displayField:i.data("displayfield"),value:i.data("value"),success:function(){e(++t,n,a)},failure:function(o){e(++t,n,a),System.showError(o)}})}i.addClass("store-inited")};e(0,o('[data-plugin="select"]:not(".store-inited")'),function(){System.debug===!0&&console.log("stores inicializados!")})},System.getControllerScope=function(){var t=e.querySelector("[ng-app=app]"),o=angular.element(t).scope();return o.$$childHead},System.getUsuario=function(){var e=System.getControllerScope();return e.Usuario},System.getPessoa=function(){var e=System.getControllerScope();return e.Usuario.Pessoa},System.setUsuario=function(e){var t=System.getControllerScope();t.$apply(function(){t.Usuario=e,t.Pessoa=e.Pessoa})},System.initAjaxEvents=function(){o(e).ajaxStart(function(){System.ajaxExecution=!0}).ajaxComplete(function(){System.ajaxExecution=!1})},System.initAutoHeight=function(e){e||(e=o("html")),e.find("[data-auto-height]").each(function(){var e=o(this);if("content"!=e.data("role")){e.attr("data-role","content"),e.removeClass("overflow-auto");var t=o('<div data-plugin="scrollable" class="overflow-auto"><div data-role="container"></div></div>');t.height(o("body").height()+parseInt(e.data("auto-height"))),e.wrap(t),e.closest('[data-plugin="scrollable"]').asScrollable(PluginAsscrollable.default.getDefaults())}else e.closest('[data-plugin="scrollable"]').asScrollable("update")})},System.initAjaxEvents(),o(t).on("load",function(){System.initStores(),System.initAutoHeight()}).on("resize",function(){System.initAutoHeight()}),o(e).on("page:loading",function(){System.loadHeader()}).on("page:ready",function(){System.doneHeader()}),init instanceof Array&&o.each(init,function(e,t){"function"==typeof t&&t()})})}(document,window,jQuery);