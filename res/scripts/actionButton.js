var ActionButton = (function(opts){

	var t = this;

	var defaults = {
		debug:true,
		buttons:[],
		tplBtn:
			'<button type="button" class="btn btn-md {{cls}} waves-effect" style="border-radius: 0">'+
	            '<i class="icon {{icon}}" aria-hidden="true"></i>'+
	            '<br>'+
	            '<span class="text-uppercase hidden-sm-down">{{text}}</span>'+
	        '</button>'
	};

	var o = $.extend({}, defaults, opts);

	var $el = $("#"+o.id);

	t.addButtons = function(buttons){

		$.each(buttons, function(index, button){

			t.addButton(button);

		});

	};

	t.addButton = function(button){

		

	};

	t.init = function(){

		$el.html('');

		t.addButtons(o.buttons);

	};

	t.init();

});