var ToolBar = (function(opts){

	var t = this;

	var defaults = {
		debug:true,
		buttons:[]
	};

	var o = $.extend({}, defaults, opts);

	var $el = $("#"+o.id);

	t.debug = function(){

		if (o.debug === true) {
			console.info.apply(console, arguments);
		}

	};

	t.addButtons = function(buttons){

		$.each(buttons, function(index, button){

			t.addButton(button);

		});

	};

	t.getTpl = function(html){

		return Handlebars.compile(html);

	};

	t.addButton = function(buttonOptions){

		var button = new Button(buttonOptions);

		var $btn = button.getElement();

		t.debug(buttonOptions, $btn);

		$el.append($btn);

	};

	t.addListener = function(listeners, $view){

		for (var eventName in listeners) {
			$view.on(eventName, function(event){
				t.debug(eventName, event, listeners, $view);
				listeners[eventName].apply(listeners[eventName], [event]);
			});
		}

	};

	t.init = function(){

		$el.html('');

		t.addButtons(o.buttons);

	};

	t.init();

});