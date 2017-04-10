window.System = {
	debug:false,
  	inactive:new Date().getTime(),
  	timerInactive:null,
  	ajaxExecution:false
};
(function(document, window, $){

	$(document).ready(function($){

		System.showError = function(r){

	      	$(document).trigger('page:ready');
	      	console.error(r);

	      	if (typeof r === 'string') r = {error:r};

	      	swal(
	        	"Cancelado!", 
	        	r.error || r.data.error || "Não foi possível executar está ação. Tente novamente mais tarde.",
	        	"error"
	      	);

	    };

	    System.loadHeader = function(){

	    };

	    System.doneHeader = function(){

	    };

	    System.success = function(message, title){

	      	if (!title) title = 'Sucesso!';
	      	if (!message) message = 'Ação realizada com sucesso. :)';

	      	if (typeof swal === 'function') {

		        swal(
	          		title,
	          		message,
	          		"success"
	        	);

	      	} else if (typeof alertify === 'object') {

	        	alertify.success(message);

	      	}

	    };

	    System.showLogin = function(){

	    };

	});

})(document, window, jQuery);