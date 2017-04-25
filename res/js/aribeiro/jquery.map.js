(function($){

	$.fn.extend({

		map:function(options){

			var defaults = {
				id: "",
				mapKey:""
			};

			var o = $.extend({}, defaults, options);

			if(!o.id){
				console.error("Informe o ID do lugar");
			}else if(!o.mapKey){
				console.error("Informe a chave do mapa");
			}else{

				return this.each(function(){

					var $div = $(this);

					rest({
						url:PATH+"/public/places/"+o.id,
						success:function(r){

							var data = r.data;

							console.log(data);

							window.initMap = function(){

								var position = {
									lat: data.vllatitude,
									lng: data.vllongitude
								};

								var zoom = data.nrzoom;

								var map = new google.maps.Map(document.getElementById(""+$div.context.id+""), {
									center:{lat: position.lat, lng: position.lng},
									zoom:zoom
								});

								var marker = new google.maps.Marker({
									position:position,
									map:map,
									draggable:true
								});

								marker.setMap(map);							

								google.maps.event.addListener(map, "rightclick", function(e){
							    	marker.setPosition(e.latLng);
								});

							}

							$("body").append('<script async defer src="https://maps.googleapis.com/maps/api/js?key='+o.mapKey+'&callback=initMap"></script>');

						},
						failure:function(r){
							System.showError(r);
						}
					});

				});

			}

		}

	});

})(jQuery);