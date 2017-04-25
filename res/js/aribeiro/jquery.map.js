(function($){

	$.fn.extend({

		map:function(options){

			var defaults = {
				id: ""
			};

			var o = $.extend({}, defaults, options);

			if(!o.id) console.error("Informe o ID do lugar");

			return this.each(function(){

				var $div = $(this);

				console.log($div);

				rest({
					url:PATH+"/public/places/"+o.id,
					success:function(r){

						var data = r.data;

						console.log(data);

						function initMap(){

							var position = {
								lat: data.vllatitude,
								lng: data.vllongitude
							};

							var zoom = data.nrzoom;

							var map = new google.maps.Map($div, {
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

					},
					failure:function(r){
						System.showError(r);
					}
				});

			});

		}

	});

})(jQuery);