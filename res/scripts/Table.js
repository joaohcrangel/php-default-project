var Table = (function(opts){

	var t = this;

	var defaults = {
		debug:false
	};

	var o = $.extend({}, defaults, opts);

	t.$el = $("#"+o.id);

	t.debug = function(){

		if (o.debug === true) {
			console.info.apply(console, arguments);
		}

	};

	t.addListener = function(listeners, $view){

		for (var eventName in listeners) {
			switch (eventName) {
				case 'selectionchange':
					t.debug('[type=checkbox]', $view.find('[type=checkbox]'));
					$view.find('[type=checkbox]').on("change", function(event){
						t.debug(eventName, event, listeners, $view);
						var $tr = $(this).closest('tr');
						listeners[eventName].apply(listeners[eventName], [$(this).prop('checked'), $(this), $tr, event]);
					});
				break;
				default:
					$view.on(eventName, function(event){
						t.debug(eventName, event, listeners, $view);
						listeners[eventName].apply(listeners[eventName], [event]);
					});
				break;
			}
		}

	};

	t.getRowsSelecteds = function(){

		var $trs = [];

		t.$el.find(':checked').each(function(){
          $trs.push($(this).closest('tr'));
        });

        return $trs;

	};

	t.init = function(){

		if (t.$el.length === 0) {
			console.error('Não foi possível encontrar a tabela com o ID #'+o.id);
		} else {

			if (typeof o.listeners === 'object') {

				t.addListener(o.listeners, t.$el);

			}

			t.debug('api', t, t.$el);
			t.$el.data('api', t);
		}

	};

	t.init();

});