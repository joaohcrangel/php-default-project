/**
 *
 * @name store
 * @version 0.1
 * @requires jQuery v1.7+
 * @author João Rangel
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 * For usage and examples, buy TopSundue:
 * 
 */
$.store = (function(){
	
	return function(options){

		var store = new (function(options){

			var tryRest = 0;
			var t = this, defaults = {
				debug:false,
				keyStorage:'sessionStore',
				cache:true,
				url:'',
				data:{},
				success:function(){},
				failure:function(){}
			};

			var o =  $.extend(defaults, options);

			t.id = o.url;
			//t.fromServer = false;

			if (!typeof sessionStorage === 'object') console.warn('O navegador não suporte sessionStorage.');

			t.clear = function(keys) {

				var store = t.getStorage();

				if (typeof keys === 'string') keys = keys.split(",");

				$.each(keys, function(index, key){

					if (store[key]) {
						store[key] = [];
						delete store[key];
					}

				});

				return t.setStorage(store);

			};

			t.clearAll = function() {

				return t.setStorage({});

			};

			t.setItem = function(key, data) {

				var store = t.getStorage();

				store[key] = data;

				return t.setStorage(store);

			};

			t.setStorage = function(data) {

				return sessionStorage.setItem(o.keyStorage, JSON.stringify(data));

			};

			t.getStorage = function() {

				var storage = sessionStorage.getItem(o.keyStorage);
				var data = {};

				if (!storage) storage = '{}';

				try {

					data = $.parseJSON(storage);

				} catch(e) {

					t.setStorage({});

				}

				return data;

			};

			t.getItem = function(key) {

				var data = t.getStorage();

				if (o.debug === true) console.log('data', data);
				if (o.debug === true) console.log('data[key]', key, data[key]);

				if (o.cache === true && data[key]) {

					if (o.debug === true) console.log('cache OK');

					if (typeof o.success === 'function') {

						//console.info('call success()', data[key]);

						o.success(data[key]);
						
					}

				} else {

					if (o.debug === true) console.log('Loading...');

					if (tryRest >= 3) {
						console.error('Não foi possível carregar o store após '+tryRest+' tentativas.');
						return true;
					}

					tryRest++;

					rest($.extend({}, o, {
						success:function(r){

							if (o.debug === true) console.log('store rest success', r);

							//t.fromServer = true;
							o.cache = true;
							t.setItem(key, r.data);
							t.getItem(key);

							t.checkStores();

							//console.info('store from server', o.url);

						},
						failure:function(r){
							if (o.debug === true) console.log('store rest error', r);
							if (typeof o.failure === 'function') o.failure(r.error || "A chave "+key+" nÃ£o existe.");
						}
					}));

				}

			};

			t.checkStores = function(){

				$.each(window.stores[store.id], function(index, _store){

					//console.log('o.$scope', typeof o.$scope);

					if (typeof o.$scope !== 'undefined') {
						o.$scope.$apply(function(){
							t.getItem(o.url);
						});
					} else {
						t.getItem(o.url);
					}

				});

			};

			t.getItem(o.url);

			t.options = o;

		})(options);

		if (typeof window.stores !== 'object') window.stores = {};

		if (!(window.stores[store.id] instanceof Array)) window.stores[store.id] = [];

		window.stores[store.id].push(store);

	};

})();