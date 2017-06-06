(function($){

	$.fn.extend({

		linkRegisters:function(data){

			var defaults = {
				title:"Vincular Cadastros",
				multiple:true,
				btnText:"Vincular",
				url:"",
				fieldList:"",
				id:"",
				selected: function(){},
				data:{},
				cache:true,
				debug:false
			};

			var o = $.extend(defaults, data);

			return this.each(function(){

				var modalId = 'modalVincular-'+new Date().getTime();

				var modal = '<div class="modal fade" id="'+modalId+'" tabindex="-1" role="dialog"  data-backdrop="false" aria-labelledby="myModalLabel"  style="z-index: 9999999;">'+
					'<div class="modal-dialog" role="document">'+
						'<div class="modal-content">'+
							'<div class="modal-header">'+
								'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
        						'<h4 class="modal-title" id="myModalLabel">'+o.title+'</h4>'+
  							'</div>'+
  							'<div class="modal-body">'+
  								'<div class="panel">'+
  									'<div id="pagination-vincular"></div>'+
  								'</div>'+
  							'</div>'+
  							'<div class="modal-footer">'+
  								'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
  								'<button type="button" class="btn btn-primary">'+o.btnText+'</button>'+
  							'</div>'+
  						'</div>'+
  					'</div>'+
  				'</div>';

				var $html = $(modal);

				console.log($html);

				$("body").append($html);

				$html.modal("show");

				var load = function(page){

					if(!page) page = 1;

					var $panel = System.getPanelApi($html.find(".panel"));

					$panel.load();

					var data = {
						page:page,
						limit:6
					}

					rest({
						url:PATH+"/persons",
						data:data,
						success:function(r){

							$panel.done();

							var config = $.extend({}, PluginAspaginator.default.getDefaults(), {
					            skin:'pagination-gap',
					            currentPage: r.currentPage,
					            itemsPerPage: r.itemsPerPage,
					            onChange: function(page){
					              
					              load(page);

					            }
				          	});

							$html.find("#pagination-vincular").asPaginator(r.total, config)

						},
						failure:function(r){
							$panel.done();
							System.showError(r);
						}
					});

				}

			});

		}

	});

})(jQuery);