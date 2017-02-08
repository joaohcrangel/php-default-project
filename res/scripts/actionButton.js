var Button = (function(opts){

	var t = this;

	var defaults = {
		debug:true,
		tpl:
			'<button type="button" class="btn btn-md {{cls}} waves-effect" style="border-radius: 0">'+
	            '<i class="icon {{icon}}" aria-hidden="true"></i>'+
	            '<br>'+
	            '<span class="text-uppercase hidden-sm-down">{{text}}</span>'+
	        '</button>'
	};

	var o = $.extend({}, defaults, opts);

	t.$el = "";

	t.debug = function(){

		if (o.debug === true) {
			console.info.apply(console, arguments);
		}

	};

	t.getTpl = function(html){

		return Handlebars.compile(html);

	};

	t.setLoad = function(load){

		return t.$el.btnload(((load === true)?'load':'unload'));

	};

	t.setDisabled = function(disabled){

		return t.$el.prop('disabled', disabled);

	};

	t.addListener = function(listeners, $view){

		for (var eventName in listeners) {
			$view.on(eventName, function(event){
				t.debug(eventName, event, listeners, $view);
				listeners[eventName].apply(listeners[eventName], [t, event]);
			});
		}

	};

	t.init = function(){

		t.$el = $((t.getTpl(o.tpl))(o));

		if (typeof o.handler === 'function') {
			if (typeof o.listeners !== 'object') {
				o.listeners = {};
			}

			o.listeners.click = o.handler;

		}

		if (typeof o.listeners === 'object') {

			t.addListener(o.listeners, t.$el);

		}

	};

	t.getElement = function(){

		return t.$el;

	};

	return t.init();

});

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