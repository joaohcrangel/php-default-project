(function($){
	
	$.fn.extend({

		selecionar:function(data){

			var defaults = {
				title:"Selecionar",
				multiple:true,
				btnText:"Salvar Dados",
				url:"",
				fieldList:"",
				id:"",
				selected: function(){},
				data:{},
				cache:true,
				debug:false
			};

			var obj = $.extend(defaults, data);

			if (!obj.tpl) obj.tpl ='{{'+obj.fieldList+'}}';

			if(!obj.url){
				console.error("Informe a URL");
			}else if(!obj.fieldList){
				console.error("Informe o campo que deve ser listado")
			}else{

				// selecionar radio button ou checkbox

				return this.each(function(){

					var modalId = 'modalDados-'+new Date().getTime();

					var html = '<div class="modal fade modal-primary bs-example-modal" id="'+modalId+'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="z-index: 9999999;">'+
			      		'<div class="modal-dialog" role="document">'+
				        	'<div class="modal-content">'+
					            '<div class="modal-header">'+					            
				              		'<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-fechar">'+
					                	'<span aria-hidden="true">×</span>'+
				              		'</button>'+
				              		'<a href="#" style="float: right;margin-right: 14px;margin-top: 2px;" id="selecionar-refresh"><i class="icon wb-refresh" aria-hidden="true"></i></a>'+
				              		'<h4 class="modal-title">'+obj.title+'</h4>'+
					            '</div>'+
					            
			              		'<div class="panel" id="table">'+					              
			                  		'<table class="table table-stripped">'+
					                    '<tbody></tbody>'+
			                  		'</table>'+
				              	'</div>'+
					              	
				            	'<div class="modal-footer">'+
				              		'<button id="salvar-dados" class="btn btn-primary btn-block">'+obj.btnText+'</button>'+
					            '</div>'+
					        '</div>'+
				      	'</div>'+
				    '</div>';

				    var $html = $(html);

				  	$("body").append($html);

				  	$('#'+modalId).on('hidden.bs.modal', function (e) {
					  $(this).remove();
					});

				  	var fnCarregarDados = function(cache){

				  		if (obj.debug === true) console.log('fnCarregarDados', obj);

				  		var panel = System.getApi('panel', $html.find('.panel'));
				  		
				  		if (panel) panel.load();

				  		System.load();

						$.store({
						  cache:cache,
					      url:obj.url,
					      data:obj.data,
					      success:function(data){

					        var tplPessoas = Handlebars.compile(tpl);

					        var table = $html.find(".panel table tbody");
					        table.html('');

					        $.each(data, function(index, row){
					        	var tr = $(tplPessoas(row));
					        	tr.find("input").data("dado", row);
					          	table.append(tr);
					        });

					        //$.components.init('iCheck');

					        System.done();
					        if (panel) panel.done();

					      },
					      failure:function(r){
					      	System.done();
					        if (panel) panel.done();
					        System.showError(r);
					      }
					    });

					};

		          	$html.modal('show');

		          	var altura = $("body").height();

				    $html.find(".panel").css({
				    	"overflow":"auto", 
				    	"height":(altura*0.8)+"px"
				    });

				    var panel = $html.find(".panel");

				    var input;

					if(obj.multiple == true){
						input = "checkbox";
					}else{
						input = "radio";
					}

				    var tpl = 
				    	'<tr>'+
				    		'<td class="w-50">'+
				    			'<span class="'+input+'-custom '+input+'-primary"><input type="'+input+'" value="{{'+obj.fieldList+'}}" name="dado"><label></label></span>'+
				    		'</td>'+
					    	'<td>'+obj.tpl+'</td>'+
					    '</tr>';

					fnCarregarDados(obj.cache);

					var fnOpen = function(){

						var dados = [];

			            $html.find("input:checked").each(function(){
			              dados.push($(this).data("dado"));
			            });
			            
		            	obj.selected(dados);

		            	$html.find(".modal-header button#btn-fechar").trigger("click");

					};

					$html.find("#salvar-dados").on("click", function(){

		            	fnOpen();

		          	});

		          	$html.find("#selecionar-refresh").on("click", function(){

		          		fnCarregarDados(false);

		          	});

				});

			}

		}

	});

})(jQuery);