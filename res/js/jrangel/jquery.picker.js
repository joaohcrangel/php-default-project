$.picker = (function(){
	
	if (typeof Handlebars !== 'object') {
		console.error("Handlebars is required.");
	}
	
	return function(_options){

		return new (function(options){
			
			var _html;

			if (!options.url) {
				switch (options.type) {
					case 'person':
					options = $.extend({
						new:{
							model:[{
								label:"Tipo de Pessoa",
								name:"idpersontype",
								type:"combo",
								combo:{
									url:"/persons-types",
									displayField:"despersontype",
									valueField:"idpersontype",
									value:1
								},
								required:true
							},{
								label:"Nome",
								name:"desperson",
								type:"string",
								required:true
							},{
								label:"E-mail",
								name:"desemail",
								type:"email",
								required:false
							}],
							textButton:"Nova Pessoa",
							url:"/persons",
							method:"post",
							failure:function(_e){

								t.showError(_e);

							}
						},
						columns:[{
							title:"Id",
							field:"idperson"
						},{
							title:"Nome",
							field:"desperson"
						},{
							title:"E-mail",
							field:"desemail"
						},{
							title:"CPF",
							field:"descpf"
						}],
						filters:[{
							type:"text",
							label:"Id",
							field:"idperson"
						},{
							type:"text",
							label:"Busca",
							field:"desperson",
							placeholder:"Nome, e-mail, cpf ou etc..."
						}],
						url:'/persons',
						title:'Selecionar Pessoas...'
					}, options);
					break;

					case 'product':
					options = $.extend({
						new:{
							model:[{
								label:"Tipo de Produto",
								name:"idproducttype",
								type:"combo",
								combo:{
									url:"/products/types",
									displayField:"desproducttype",
									valueField:"idproducttype",
									value:1
								},
								required:true
							},{
								label:"Nome do Produto",
								name:"desproduct",
								type:"string",
								required:true
							},{
								label:"Preço",
								name:"vlprice",
								type:"decimal",
								required:false
							}],
							textButton:"Novo Produto",
							url:"/produtcs",
							method:"post",
							failure:function(_e){

								t.showError(_e);

							}
						},
						columns:[{
							title:"Id",
							field:"idproduct"
						},{
							title:"Produto",
							field:"desproduct"
						},{
							title:"Tipo",
							field:"desproducttype"
						},{
							title:"Preço",
							field:"desvlprice"
						}],
						filters:[{
							type:"text",
							label:"Id",
							field:"idproduct"
						},{
							type:"text",
							label:"Busca",
							field:"desproduct"
						}],
						url:'/products',
						title:'Selecionar Produtos...'
					}, options);
					break;
				}	
			}
			
			var id = 'id-'+new Date().getTime();

			var t = this, defaults = {
				title:"Selecionar...",
				debug:false,
				cache:true,
				valueField:'',
				displayField:'',
				url:'',
				multiple:false,
				select:function(objects){

				},
				tpl:Handlebars.compile(
					'<div class="panel panel-primary panel-line is-fullscreen" id="panel-picker">'+
			            '<div class="panel-heading">'+
			            	'<h3 class="panel-title">{{title}}</h3>'+
			            	'<div class="panel-actions panel-actions-keep">'+
				                '<a class="panel-action icon md-close" aria-hidden="true" id="btn-picker-close"></a>'+
				            '</div>'+
			            '</div>'+
			            '<div class="panel-body p-y-10 p-x-0" style="height:{{height}}px; overflow:auto; background: #f1f4f5;">'+
			             	'<div class="row-fluid">'+
			             		'<div class="col-md-3">'+		             			
			             			'<div class="panel">'+
							            '<div class="panel-body">'+
							            	'<form id="form-picker-filters">'+
							              		'{{{filters}}}'+
							              		'<button type="submit" class="btn btn-primary btn-block waves-effect">Buscar</button>'+
							              		'<hr />'+
							              		'<div style="text-align:center;">ou</div>'+
							              		'<hr />'+
			             						'<button type="button" id="btn-picker-new" class="btn btn-success btn-block waves-effect">{{new.textButton}}</button>'+
							              	'</form>'+
							            '</div>'+
							        '</div>'+
			             		'</div>'+
			             		'<div class="col-md-9">'+
			             			'<div class="panel">'+
							            '<div class="panel-body">'+
							              '<table class="table table-hover" data-plugin="selectable" data-row-selectable="true">'+
						                    '<thead>'+
						                      '<tr>'+
						                      '</tr>'+
						                    '</thead>'+
						                    '<tbody>'+					                      
						                    '</tbody>'+
						                  '</table>'+
							            '</div>'+
							        '</div>'+
			             		'</div>'+
			             	'</div>'+
			            '</div>'+
			            '<div class="panel-footer" style="padding:20px;">'+
			             	'<button type="button" id="btn-picker-select" class="btn btn-primary waves-effect pull-xs-right">Selecionar</button>'+
			             	'<button type="button" id="btn-picker-cancel" class="btn btn-default waves-effect pull-xs-left">Cancelar</button>'+
			            '</div>'+
			        '</div>'
				),
				tplColumn:Handlebars.compile(
					'<th>{{title}}</th>'
				),
				tplColumnCheck:Handlebars.compile(
					'<th class="w-50">'+
                      '<span class="checkbox-custom checkbox-primary">'+
                        '<input class="selectable-all" type="checkbox">'+
                        '<label></label>'+
                      '</span>'+
                    '</th>'
				),
				tplResult:Handlebars.compile(
					'<td>{{value}}</td>'
				),
				tplResultCheck:Handlebars.compile(
					'<td>'+
                      '<span class="checkbox-custom checkbox-primary">'+
                        '<input class="selectable-item" type="checkbox" id="row-619" value="619">'+
                        '<label for="row-619"></label>'+
                      '</span>'+
                    '</td>'
				),
				tplResultRadio:Handlebars.compile(
					'<td>'+
                      '<span class="radio-custom radio-primary">'+
                        '<input class="selectable-item" type="radio" name="select" id="row-619" value="619">'+
                        '<label for="row-619"></label>'+
                      '</span>'+
                    '</td>'
				),
				tplFilter:{
					text:Handlebars.compile(
						'<div class="form-group form-material" data-plugin="formMaterial">'+
							'<label class="form-control-label" for="{{field}}">{{label}}</label>'+
							'<input type="text" class="form-control" name="{{field}}" id="{{field}}" placeholder="{{placeholder}}">'+
						'</div>'
					)
				},
				tplAlertError:Handlebars.compile(
					'<div class="alert alert-danger alert-dismissible" role="alert">'+
		              '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
		                '<span aria-hidden="true">×</span>'+
		                '<span class="sr-only">Close</span>'+
		              '</button>'+
		              '<span class="msg">{{error}}</span>'+
		            '</div>'
				),
				tplModalNew:Handlebars.compile(
					'<div class="modal modal-success fade modal-3d-sign in" id="modal-picker-new" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">'+
	                    '<div class="modal-dialog">'+
	                      '<div class="modal-content">'+
	                        '<div class="modal-header">'+
	                          '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
	                            '<span aria-hidden="true">×</span>'+
	                          '</button>'+
	                          '<h4 class="modal-title">{{new.textButton}}</h4>'+
	                        '</div>'+
	                        
	                        '<form>'+
		                        '<div class="modal-body">'+
		                          
		                        '</div>'+
		                        '<div class="modal-footer">'+
		                          '<button type="button" class="btn btn-default btn-pure waves-effect" data-dismiss="modal">Cancelar</button>'+
		                          '<button type="submit" class="btn btn-success waves-effect">Salvar e Selecionar</button>'+
		                        '</div>'+
	                        '</form>'+
	                      '</div>'+
	                    '</div>'+
	                '</div>'
				),
				tplNew:{
					string:Handlebars.compile(
						'<div class="form-group form-material" data-plugin="formMaterial">'+
							'<label class="form-control-label" for="{{id}}">{{label}}</label>'+
							'<input type="text" class="form-control" name="{{name}}" id="{{id}}" placeholder="{{placeholder}}">'+
						'</div>'
					),
					int:Handlebars.compile(
						'<div class="form-group form-material" data-plugin="formMaterial">'+
							'<label class="form-control-label" for="{{id}}">{{label}}</label>'+
							'<input type="number" class="form-control" name="{{name}}" id="{{id}}" placeholder="{{placeholder}}">'+
						'</div>'
					),
					date:Handlebars.compile(
						'<div class="form-group form-material" data-plugin="formMaterial">'+
							'<label class="form-control-label" for="{{id}}">{{label}}</label>'+
							'<input type="date" class="form-control" name="{{name}}" id="{{id}}" placeholder="{{placeholder}}">'+
						'</div>'
					),
					email:Handlebars.compile(
						'<div class="form-group form-material" data-plugin="formMaterial">'+
							'<label class="form-control-label" for="{{id}}">{{label}}</label>'+
							'<input type="email" class="form-control" name="{{name}}" id="{{id}}" placeholder="{{placeholder}}">'+
						'</div>'
					),
					combo:Handlebars.compile(
						'<div class="form-group form-material" data-plugin="formMaterial">'+
							'<label class="form-control-label" for="{{id}}">{{label}}</label>'+
							'<select class="form-control" name="{{name}}" id="{{id}}"></select>'+
						'</div>'
					)
				}
			};

			var o =  $.extend(defaults, options);

			t.new = function () {

				var $modal = $(o.tplModalNew(o));

				$("#modal-picker-new").remove();

				$("body").append($modal);

				t.initFormNew();

				$modal.modal("show");

				$modal.css({'z-index':'10001'});
				$(".modal-backdrop.in").css({'z-index':'10000'});

			};

			t.getFiltersHTML = function(){

				var html = '';

				$.each(o.filters, function (index, filter) {

					html += o.tplFilter[filter.type](filter);

				});

				return html;

			};

			t.callRest = function(){

				var $form = _html.find("#form-picker-filters");
				var params = $form.formValues();
				var valid = false;

				for (var key in params) {
					if (params[key].length > 0) valid = true;
				}

				if (valid) {

					rest({
						cache:o.cache,
						url:o.url,
						method:o.method,
						data:params,
						success:function(r){
							t.setResult(r.data);
						},
						failure:function(e){
							t.showError(e);
						}
					});

				} else {

					t.showError({
						error:"Preencha algum campo para fazer a busca"
					});

				}				

			};

			t.showError = function(e){

				if (typeof System === "object" && typeof System.showError === "function") {
					System.showError(e);
				}

			};

			t.setResult = function(result){

				var _resultHTML = [];

				if (result.length > 0) {

					$.each(result, function (index2, row) {

						if (o.multiple) {

							var $tr = $("<tr>"+o.tplResultCheck({})+"</tr>");

						} else {

							var $tr = $("<tr>"+o.tplResultRadio({})+"</tr>");

						}

						$tr.data("object", row);

						$.each(o.columns, function (index1, column) {

							var $td = $(o.tplResult({
								value:row[column.field]
							}));

							$tr.append($td);

						});

						_resultHTML.push($tr);

					});

				}

				_html.find("tbody").html("");
				_html.find("tbody").append(_resultHTML);

				_html.find("tbody").find("tr").on("click", function (e) {

					if (e.target.tagName !== 'INPUT') {
						var $input = $(this).find("input:checkbox");
						$input.prop("checked", !$input.prop("checked"));
						$input.trigger("change");
					}

				});

				_html.find("tbody").find("tr").find("input:checkbox").on("change", function () {

					var checked = $(this).prop("checked");
					var $tr = $(this).closest("tr");

					if (checked) {
						$tr.addClass("table-active");
					} else {
						$tr.removeClass("table-active");
					}

				});

			};

			t.select = function(){

				var itens = [];

				$("#panel-picker tbody input:checked").each(function () {

					itens.push($(this).closest("tr").data("object"));

				});

				o.select(itens);
				t.close();

			};

			t.initForm = function(){

				var $form = _html.find("#form-picker-filters");

				$form.find("[type=submit]").on("click", function(e){

				    e.preventDefault();

				    //$('.page-aside-switch:visible').trigger('click');

				    t.callRest();

				});

				$form.find("input").on("keyup", function(e){

				    if (e.keyCode === 13) $form.find("[type=submit]").trigger("click");

				});

			};

			t.initColumns = function(){

				var _columnsHTML = o.tplColumnCheck({});

				$.each(o.columns, function (index, column) {

					_columnsHTML += o.tplColumn(column);

				});

				_html.find("thead").find("tr").html(_columnsHTML);

				if (!o.multiple) {
					_html.find("thead").find("input").remove();
					_html.find("thead").find(".checkbox-custom").remove();
				} else {
					_html.find("thead").find("input:checkbox").on("change", function () {

						$("#panel-picker tbody input:checkbox").prop("checked", $(this).prop("checked")).trigger("change");

					});
				}				

			};

			t.initButtons = function(){

				_html.find("#btn-picker-select").on("click", function () {

					var $btn = $(this);

					$btn.btnload("load");

					t.select();

				});

				_html.find("#btn-picker-cancel").on("click", function () {

					var $btn = $(this);

					$btn.btnload("load");

					t.close();
					
				});

				_html.find("#btn-picker-close").on("click", function () {

					t.close();
					
				});

				_html.find("#btn-picker-new").on("click", function () {

					t.new();

				});

			};

			t.initFormNew = function () {

				var $modal = $("#modal-picker-new");
				var $form = $modal.find("form");

				$.each(o.new.model, function (index, item) {

					item.id = item.name+index;

					var $item = $(o.tplNew[item.type](item));

					switch (item.type) {
						case "combo":

						if (item.combo) $item.find("select").combobox(item.combo);

						break;
					}

					$form.find('.modal-body').append($item);

				});

				o.new.success = function (_result) {

					$modal.modal("hide");
					o.select([_result.data]);
					t.close();

				};

				o.new.failure = function (e) {

					$modal.find(".alert-danger").remove();
					var $alertError = $(o.tplAlertError(e));
					$alertError.insertAfter($modal.find(".modal-body"));

				};

				$form.form(o.new);

			};

			t.init = function(){
				
				o.height = getPageSize().height-140;
				o.filters = t.getFiltersHTML();

				_html = $(o.tpl(o));

				t.initForm();
				t.initColumns();
				t.initButtons();

				$("#panel-picker").remove();
				$("body").append(_html);
				
			};

			t.close = function () {

				$("#panel-picker").remove();

			};
			
			t.init();

		})(_options);

	};

})();

(function($){

 	$.fn.extend({

 		pickerPerson:function(options) {

 			var defaults = {
				debug:false,
				primarykey:"idperson",
				defaultPhotoUrl:"/res/theme/material/global/photos/placeholder.png",
				defaultName:"...",
				textButton:"Selecionar Pessoa",
				textButtonChange:"Alterar Pessoa",
				tpl:Handlebars.compile(
					'<div class="media">'+
					  '<div class="media-left">'+
					    '<a class="avatar" href="javascript:void(0)">'+
					      '<img class="img-fluid" src="{{defaultPhotoUrl}}">'+
					    '</a>'+
					  '</div>'+
					  '<div class="media-body">'+
					    '<h4 class="media-heading">{{defaultName}}</h4>'+
					    '<small>{{defaultSubtitle}}</small>'+
					  '</div>'+
					  '<div class="media-right">'+
					    '<button type="button" class="btn btn-primary waves-effect">{{textButton}}</button>'+
					  '</div>'+
					'</div>'
				)
			};

			var o =  $.extend(defaults, options);

			if(o.debug === true) console.info("options", o);

    		return this.each(function() {

    			var t = this;
    			var $el = $(t);
    			var $wrap = $('<div class="picker-person"></div>');
    			
    			$el.wrap($wrap);
    			$el.hide();

    			var $pickerPerson = $el.closest(".picker-person");

    			$wrap.find(".media").remove();
    			$pickerPerson.append(o.tpl(o));

    			function initButton () {

    				$pickerPerson.find("button").on("click", function () {

	    				$.picker({
							type:"person",
							select:function (persons) {

								$pickerPerson.find(".media").remove();
		    					$pickerPerson.append(o.tpl({
		    						defaultPhotoUrl:persons[0].desphotourl || o.defaultPhotoUrl,
		    						defaultName:persons[0].desperson || o.defaultName,
		    						defaultSubtitle:persons[0].desemail || "",
		    						textButton:o.textButtonChange
		    					}));

		    					$el.val(persons[0][o.primarykey]);

		    					initButton();

							}
						});

	    			});

    			}

    			initButton();		

    		});

 		},

 		pickerProduct:function(options) {

 			var defaults = {
				debug:false,
				primarykey:"idproduct",
				defaultPhotoUrl:"/res/theme/material/global/photos/placeholder.png",
				defaultName:"...",
				textButton:"Selecionar Produto",
				textButtonChange:"Alterar Produto",
				tpl:Handlebars.compile(
					'<div class="media">'+
					  '<div class="media-left">'+
					    '<a class="avatar" href="javascript:void(0)">'+
					      '<img class="img-fluid" src="{{defaultPhotoUrl}}">'+
					    '</a>'+
					  '</div>'+
					  '<div class="media-body">'+
					    '<h4 class="media-heading">{{defaultName}}</h4>'+
					    '<small>{{defaultSubtitle}}</small>'+
					  '</div>'+
					  '<div class="media-right">'+
					    '<button type="button" class="btn btn-primary waves-effect">{{textButton}}</button>'+
					  '</div>'+
					'</div>'
				)
			};

			var o =  $.extend(defaults, options);

			if(o.debug === true) console.info("options", o);

    		return this.each(function() {

    			var t = this;
    			var $el = $(t);
    			var $wrap = $('<div class="picker-product"></div>');
    			
    			$el.wrap($wrap);
    			$el.hide();

    			var $pickerProduct = $el.closest(".picker-product");

    			$wrap.find(".media").remove();
    			$pickerProduct.append(o.tpl(o));

    			function initButton () {

    				$pickerProduct.find("button").on("click", function () {

	    				$.picker({
							type:"product",
							select:function (products) {

								$pickerProduct.find(".media").remove();
		    					$pickerProduct.append(o.tpl({
		    						defaultPhotoUrl:products[0].desphotourl || o.defaultPhotoUrl,
		    						defaultName:products[0].desproduct || o.defaultName,
		    						defaultSubtitle:products[0].desproducttype || "",
		    						textButton:o.textButtonChange
		    					}));

		    					$el.val(products[0][o.primarykey]);

		    					initButton();

							}
						});

	    			});

    			}

    			initButton();		

    		});

 		}

 	});

})(jQuery);