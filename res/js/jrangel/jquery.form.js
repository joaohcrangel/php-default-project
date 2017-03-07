/**
 *
 * @name form
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

 		formValueCheck:function(options) {

 			var defaults = {
				debug:false,
				icon:'md-pin',
				iconError:'md-alert-octagon red-500',
				iconPosition:'form-control-icon-right',
				delay:250,
				cache:true,
				url:'',
				minLengthSubmit:8,
				success:function(){},
				failure:function(){}
			};

			var o =  $.extend(defaults, options);

			if(o.debug === true) console.info("options", o);

    		return this.each(function() {

    			var t = this;
    			var $el = $(t);

    			if(o.debug === true) console.info(t, $el);

    			$el.wrap('<div class="input-group"></div>');

    			var $inputGroup = $el.closest('.input-group');
    			var $icon = $('<i class="form-control-icon '+o.iconPosition+' '+o.icon+'"></i>');
    			var $input = $el;

    			$inputGroup.css({
    				'position':'relative'
    			});

    			$icon.css({
    				'position': 'absolute',
				    'right': 0,
				    'top': 0,
				    'z-index': 99999,
				    'margin': '7px 14px'
    			});
    			
    			$inputGroup.append($icon);
    			//$inputGroup.append($input);

    			if(o.debug === true) console.info($input);

    			$input.on('keydown', function(e){

    				if(o.debug === true) console.info('keydown', e);

    				if (e.keyCode === 13) {

    					e.stopPropagation();
                        e.preventDefault();

    				}

    			});

    			$input.on('keyup', function(e){

    				if(o.debug === true) console.info('keyup', e);

    				if (getValue().length === o.minLengthSubmit) loadRest();

    			});

    			$input.on('blur', function(e){

    				if(o.debug === true) console.info('blur', e);

    				if (getValue().length === o.minLengthSubmit) loadRest();

    			});

    			$input.on('change', function(e){

    				if(o.debug === true) console.info('change', e);

    				if (getValue().length === o.minLengthSubmit) loadRest();

    			});

    			$input.on('paste', function(e){

    				if(o.debug === true) console.info('paste', e);

    				if (getValue().length === o.minLengthSubmit) loadRest();

    			});

    			function getValue(){

    				var value = $input.val().replace('-','');
    				return value;

    			}

    			function setLoading(bool){

    				if (bool) {
    					$icon.removeClass(o.icon);
    					$icon.addClass('fa fa-refresh fa-spin').css({
    						'margin':'11px 14px'
    					});
    				} else {
    					$icon.removeClass('fa fa-refresh fa-spin');
    					$icon.addClass(o.icon).css({
    						'margin':'7px 14px'
    					});
    				}

    			}

    			function loadRest(){

    				setLoading(true);

    				$.store({
    					cache:o.cache,
    					url:o.url+'/'+getValue(),
    					success:function(r){
    						setLoading(false);
    						o.success(r);
    					},
    					failure:function(e){
    						setLoading(false);
    						o.failure(e);
    					}
    				});

    			}

    		});

 		},

 		formValues:function() {

 			var t = this,
 				$form = $(t);

 			t.data = {};

			$.each($form.serializeArray(), function(){

				if(this.name.indexOf("[]") === -1) t.data[this.name] = this.value;

			});

			$form.find(".select2-container").each(function(){
				t.data[$(this).next("select").attr("name")] = $(this).next("select").select2("val");
			});

			return t.data;

 		},

 		formLoad:function(data) {

 			var t = this;
			var $form = $(t);

 			for (var item in data) {

 				var $element = $form.find('[name="'+item+'"]'),
 					element = $element[0];
 					
 				if ($element.length === 1) {

	 				switch (element.tagName.toLowerCase()) {

	 					case 'input':
	 					switch (element.type.toLowerCase()) {
	 						case 'radio':
	 						case 'checkbox':
	 						$element.prop('checked', true).val(data[item]);
	 						break;

	 						default:
	 						$element.val(data[item]);
	 						break;
	 					}
	 					break;

	 					case 'select':
	 					$element.find(':selected').removeAttr('selected').prop('selected', false);
	 					if (data[item]) {
			                $element.find('[value='+data[item]+']').attr('selected', 'selected').prop('selected', true);
			            } else {
			              $element.find(':disabled').removeAttr('disabled').prop('selected', true).prop('disabled', true);
			            }
	 					break;

	 					case 'textarea':
	 					$element.html(data[item]);
	 					break;

	 				}

	 			} else if($element.length > 1) {

	 				$element.removeAttr('checked').prop('checked', false);
	 				if (data[item]) {
			            $element.filter('[value='+data[item]+']').attr('checked', 'checked').prop('checked', true);
			        } else {
			            $element.find(':disabled').removeAttr('disabled').prop('selected', true).prop('disabled', true);
			        }

	 			}

 			}

 			if ($.components !== undefined) {
 				$.components.init('iCheck');
 			}

 			return true;

 		},

		//pass the options variable to the function
 		form: function(options) {

			//Set the default values, use comma to separate the settings, example:
			var defaults = {
				debug:false,
				params:{},
				url:"",
				method:"POST",
				dataType:"json",
				resetForm:true,
				parentCls:"form-group",
				errorCls:"has-error",
				success:function(){},
				failure:function(r){ System.showError(r); },
				startAjax:function(){},
				validadeField:function(field){ return true; },
				alertError:function(msg){



				},
				alertSuccess:function(msg){



				},
				alertInfo:function(msg){



				}
			};

			var o =  $.extend(defaults, options);

    		return this.each(function() {

    			var t = this;

				var $form = $(t),
					$btn = $form.find('[type="submit"]'),
					btnText = $btn.text() || $btn.val()
					;

				if(!o.url && $form.attr("action")) o.url = $form.attr("action");

				if(o.debug === true) console.info("options", o);

				$form.find('input').on('change', function(){
					if ($(this).val().length) {
						$(this).removeClass('empty');
					} else {
						$(this).addClass('empty');
					}
				});

				$btn.on("click", function(e){

					if(o.debug === true) console.info("click", e);

					e.preventDefault();

					$btn.btnload("load");

					$form.find("."+o.errorCls).removeClass(o.errorCls);

					$form.find('[name]').each(function(){

						if(o.validadeField(this) === false){

							if(o.debug === true) console.info("validade field", this);
							$(this).closest("."+o.parentCls).addClass(o.errorCls);

						}

					});

					$form.find('[required]').each(function(){

						if(o.debug === true) console.info("required", this);

						var $element = $(this);

						switch(this.tagName){

							case "SELECT":
							if(!$element.find("option:selected").length){
								$element.closest("."+o.parentCls).addClass(o.errorCls);
							}
							break;

							default:
							if(!$element.val().length){
								$element.closest("."+o.parentCls).addClass(o.errorCls);
							}
							break;

						}

					});

					if($form.find("."+o.errorCls).length){

						o.alertError("Verifique os campos do formulário.");

						$btn.btnload("unload");

					}else{

						o.alertInfo("Enviando formulário...");

						t.data = {};

						$.each($form.serializeArray(), function(){

							if(this.name.indexOf("[]") === -1) t.data[this.name] = this.value;

						});

						if(o.params){

							t.data =  $.extend(t.data, o.params);

						}

						$form.find(".select2-container").each(function(){
							t.data[$(this).next("select").attr("name")] = $(this).next("select").select2("val");
						});

						if(o.debug === true) console.info("data 1", t.data);

						if(typeof o.startAjax === "function") o.startAjax(t.data);

						if (typeof o.beforeParams === 'function') t.data =  $.extend({}, o.beforeParams(t.data), t.data);

            			if(o.debug === true) console.info("data 2", t.data);

						var data = $.param(t.data);

            			if(o.debug === true) console.info("data 3", data);

						var datas = [];
						$form.find("[name*='[]']").each(function(){

							datas.push($(this).serialize());

						});

						if(data.length) data += "&";

						data += datas.join("&");

            			if(o.debug === true) console.info("data 4", data);

			            rest({
			              $http: o.$http,
			              url: o.url,
										method: o.method,
										data: data,
			              success:function(r) {

			                $btn.btnload("unload");
			                if(typeof o.success === "function") o.success(r);

											if(o.resetForm === true){
												$form.find('[name]:not([data-no-reset-form])').each(function(){

													$(this).val('');

												});
											}

											o.alertSuccess("Formulário enviado com sucesso!");

											if(o.debug === true) console.info("success", r);

			              },
			              failure:function(e) {

			  							$btn.btnload("unload");
			                if(typeof o.failure === "function") o.failure(e);

			              }
			            });

								}

								return false;

							});

			    		});
    	}
	});

})(jQuery);
