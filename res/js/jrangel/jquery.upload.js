/**
 *
 * @name upload
 * @version 0.1
 * @requires jQuery v1.7+
 * @author João Rangel
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 * For usage and examples, buy TopSundue:
 * 
 */
(function($){

  $.fn.extend({ 
    
    //pass the options variable to the function
    upload: function(options) {

      //Set the default values, use comma to separate the settings, example:
      var defaults = {
        debug:false,
        url:"",
        onchange:true,
        autoOpen:false,
        modalInfo:false,
        fileSizeMax:(1024 * 1024 * 2),
        fileMax:20,
        inputName:'arquivo',
        tplModalRow:Handlebars.compile(
          '<tr>'+
            '<td>{{name}}<small style="display:block;font-size:10px;" class="grey-500"></small></td>'+
            '<td>{{humanSize}}</td>'+
            '<td style="width:150px;">'+
              '<div class="progress progress-xs m-y-10 ">'+
                '<div class="progress-bar progress-bar-primary" style="width: 0%"></div>'+
              '</div>'+
            '</td>'+
            '<td style="width:30px;" class="actions"></td>'+
          '</tr>'),
        tplActionBtnCancel:Handlebars.compile(
          '<button type="button" class="btn btn-sm btn-icon btn-flat btn-default waves-effect" data-toggle="tooltip" data-original-title="Delete">'+
            '<i class="icon md-close" aria-hidden="true"></i>'+
          '</button>'),
        tplActionIconLoading:Handlebars.compile(
          '<i class="fa fa-reload fa-spin {{cls}}"></i>'
        ),
        tplActionIconError:Handlebars.compile(
          '<i class="icon md-alert-triangle {{cls}}"></i>'
        ),
        tplActionIconOK:Handlebars.compile(
          '<i class="icon md-check {{cls}}"></i>'
        ),
        tplModal:Handlebars.compile(
          '<div class="modal fade" id="jrangel-upload" aria-hidden="true" aria-labelledby="examplePositionSidebar" role="dialog" tabindex="-1">'+
            '<div class="modal-dialog modal-sidebar modal-md">'+
              '<div class="modal-content">'+
                '<div class="modal-header">'+
                  '<h4 class="modal-title indigo-500">Enviar para a nuvem</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                  '<table class="table">'+
                    '<tbody></tbody>'+
                  '</table>'+
                '</div>'+
                '<div class="modal-footer">'+
                  //'<button type="button" class="btn btn-default btn-block">Adicionar mais arquivos</button>'+
                  '<button type="button" class="btn btn-primary btn-block btn-ok" disabled>Pronto!</button>'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'),
        success:function(){},
        failure:function(){},
        startAjax:function(){},
        complete:function(){}
      };
        
      var o =  $.extend(defaults, options);

        return this.each(function() {

          if (o.debug === true) console.info("jquery upload init", this);
          if (!o.url) {
            console.error('Informe a URL que receberá o UPLOAD');
          }

        var t = this;

        t.resultFiles = [];

        var $input = $(t);

        var iframeName = "iframe-upload-"+new Date().getTime();
        var $iframe = $('<iframe name="'+iframeName+'" class="hide" width="1" height="1"></iframe>');

        $iframe.appendTo('body');
        $input.wrap('<form action="'+o.url+'" method="POST" enctype="multipart/form-data" target="'+iframeName+'"></form>');
        var $form = $input.parents('form');

        if (o.debug === true) {
          console.info('iframeName', iframeName);
          console.info('input', $input);
          console.info('iframe', $iframe);
          console.info('form', $form);
        }

        $iframe.on('load', function(){

          if (o.debug === true) console.warn("iframe load", $iframe);

          try {

            var r = $.parseJSON($iframe[0].contentDocument.body.innerText);

            if (r.success){

              if (o.debug === true) console.info("success", r);

              if (typeof o.success === 'function') o.success(r);

            } else {

              if (o.debug === true) console.info("failure", r);

              if (typeof o.failure === 'function') o.failure(r);

            }

            if (typeof o.complete === 'function') o.complete(r);

          } catch(e) {

            if (typeof o.failure === 'function') o.failure(r);

          }

        });

        if (o.onchange === true) {

          $input.on('change', function(event){

          	var files = this.files;

            if (o.debug === true) console.warn("input change", $input);

            if (files.length) {

              if (typeof o.selectfiles === 'function') o.selectfiles(files);
              
              $.store({
	        	url:PATH+"/arquivos-upload_max_filesize",
	        	success:function(data){

	        		o.fileSizeMax = parseInt(data);
	        		
	        		$.each(files, function(index, file){

		                t.addFileToQueue(file);

		            });

		            t.startUpload();

	        	}
		      });

            }

          });

        };

        t.initModal = function(){

          var $modal = $(o.tplModal({}));
          $modal.modal('hide');

          $modal.find('.btn-ok').on('click', function(){
            $modal.modal('hide');
          });

          $modal.find('.modal-body').addClass('overflow-auto').css({
          	'max-height':(window.innerHeight-120)+'px'
          });

          $modal.appendTo('body');

          return $modal;

        };

        t.addFileToQueue = function(file){

          file.humanSize = t.humanSize(file.size);
          var $tr = $(o.tplModalRow(file));

          $tr.data('file', file);

          if (file.size > o.fileSizeMax) {

          	console.error(file.size, t.humanSize(file.size));
          	console.error(o.fileSizeMax, t.humanSize(o.fileSizeMax));

            $tr.find('small').html("Não é possível enviar um arquivo maior que "+t.humanSize(o.fileSizeMax)+".");
            $tr.find('.actions').html(o.tplActionIconError({
              cls:'red-500'
            }));
            $tr.addClass('complete red-500');

          } else {

          	var $btnCancel = $(o.tplActionBtnCancel({}));

            $btnCancel.on('click', function(){

	          	$(this).closest('tr').remove();

	        });

            $tr.find('.actions').html($btnCancel);

          }

          t.$modal.find('tbody').append($tr);

        };

        t.done = function(){

          $('body').off('onbeforeunload');
          if (typeof o.success === 'function') o.success({
            success:true,
            data:t.resultFiles
          });

          t.$modal.find('.btn-ok').prop('disabled', false);

        };

        t.startUpload = function(){

          if (o.modalInfo === true) t.$modal.modal('show');

          $('body').on('onbeforeunload', function(){

            return 'Deseja cancelar o envio dos arquivos para a nuvem?';

          });

          t.resultFiles = [];

          t.upload(function(){

            t.done();

          });

        };

        t.upload = function(callback){

          var $tr = t.$modal.find('tbody').find('tr:not(.complete):first');

          if (o.debug === true) console.log($tr[0], $tr);

          if (!$tr.length) {

            if (typeof callback === 'function') callback();
            return false;

          }
          /*
          var hM = window.innerHeight/2;
          t.$modal.find('.modal-body').scrollTop($tr[0].offsetTop - hM);
		  */
          var file = $tr.data('file');

          if (o.debug === true) console.log(file);

          $tr.addClass('processing');

          var formData = new FormData();
          formData.append(o.inputName, file);

          var oReq = new XMLHttpRequest();

          oReq.addEventListener("progress", function(evt){

          	if (o.debug === true) console.info("progress");

            $tr.find('.actions').html(o.tplActionIconLoading({}));

            if (o.debug === true) console.info("progress");
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;            
              $tr.find('.progress-bar').width(parseInt(percentComplete*100)+'%');
            } else {
              // Não é possível calcular informações de progresso uma vez que a dimensão total é desconhecida
            }

          }, false);
          oReq.addEventListener("load", function(evt){

            if (o.debug === true) console.info("load");
            $tr.removeClass('processing').addClass('complete');

          }, false);
          oReq.addEventListener("error", function(evt){

            $tr.find('.actions').html(o.tplActionIconError({
              cls:'red-500'
            }));
            $tr.addClass('red-500');
            if (o.debug === true) console.error("error");
            
          }, false);
          oReq.addEventListener("abort", function(evt){

            $tr.find('.actions').html(o.tplActionIconError({
              cls:'amber-500'
            }));
            if (o.debug === true) console.info("abort");
            
          }, false);
          oReq.addEventListener("loadend", function(evt){

          	if (o.debug === true) console.info("loadend");

          	t.upload(callback);

          }, false);

          oReq.addEventListener("readystatechange", function(evt){

          	if (o.debug === true) console.info("readystatechange", oReq.readyState);

          	if (oReq.readyState === 4) {
          		var result = JSON.parse(oReq.response);
          		if (result.success) {
          			$.each(result.data, function(index, data){
          				t.resultFiles.push(data);
          			});
          			$tr.find('.actions').html(o.tplActionIconOK({
		              cls:'green-500'
		            }));
          		} else {
          			$tr.find('small').html(result.error);
          			$tr.find('.actions').html(o.tplActionIconError({
		              cls:'red-500'
		            }));
		            $tr.addClass('red-500');
          		}
	        }

          });

          oReq.open('POST', o.url, true);
          
          oReq.send(formData);

        };

        t.humanSize = function(bytes, si){

          var thresh = 1024;
          if(Math.abs(bytes) < thresh) {
              return bytes + ' B';
          }
          var units = ['kB','MB','GB','TB','PB','EB','ZB','YB'];
          var u = -1;
          do {
              bytes /= thresh;
              ++u;
          } while(Math.abs(bytes) >= thresh && u < units.length - 1);
          return bytes.toFixed(1)+' '+units[u];

        };

        t.getTotalSize = function(files){

          var total = 0;
          $.each(files, function(index, file){

            total += file.size;

          });

          return total;

        };

        t.submit = function(){

          if (typeof o.startAjax === 'function') o.startAjax($input[0].files);

          $form.submit();

        };

        t.open = function(){

          $input.click();

        };

        if (o.autoOpen === true) t.open();

        t.$modal = t.initModal();

        $(t).data('api', t);
      
        });

      }

  });
  
})(jQuery);

$.upload = (function(){
  
  return function(options){

    return new (function(options){

      var tryRest = 0;
      var t = this, defaults = {
        debug:false,
        url:'',
        autoOpen:true,
        multiple:false,
        accept:"image/*",
        inputName:"arquivo",
        success:function(){},
        failure:function(r){System.showError(r);}
      };

      var o =  $.extend(defaults, options);

      if (o.multiple === true) {
        o.inputName = o.inputName + '[]';
      }

      var $inputFile = $('<input type="file" name="'+o.inputName+'" accept="'+o.accept+'">');

      if (o.multiple === true) {
        $inputFile.attr("multiple", "multiple");
      }

      $inputFile.hide();
      $inputFile.appendTo("body");

      $inputFile.upload(o);

      var api = $inputFile.data('api');

      return api;

    })(options);

  };

})();