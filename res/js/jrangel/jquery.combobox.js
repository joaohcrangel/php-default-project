/**
 *
 * @name combobox
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

        //pass the options variable to the function
        combobox: function(options) {

            //Set the default values, use comma to separate the settings, example:
            var defaults = {
                debug:false,
                method:'GET',
                cache:true,
                valueField:'',
                displayField:'',
                url:'',
                value:undefined,
                emptyText:'-- selecione --',
                multiple:false,
                select2:false
            };

            var o =  $.extend(defaults, options);

            if (o.debug === true) console.log('options', o);

            return this.each(function() {

                var $el = $(this);

                if (o.debug === true) console.log('element', this);

                var successCombo = function(o, $el, data){

                    if (o.debug === true) console.log('success', data);

                    $el.html('');

                    $.each(data, function(index, item){

                        var value = [], display = [];

                        $.each(o.valueField.split(' '), function(indexValue, itemValue){
                            value.push(item[itemValue]);
                        });
                        $.each(o.displayField.split(' '), function(indexDisplay, itemDisplay){
                            display.push(item[itemDisplay]);
                        });

                        $el.append('<option value="'+value.join(' ')+'">'+display.join(' ')+'</option>');

                    });

                    if (o.debug === true) console.log('value', o.value);

                    $el.find(":selected").removeAttr("selected");

                    if (o.value !== undefined) {

                        if (o.value instanceof Array) {

                            $.each(o.value, function(i1, v1){
                                if (v1) $el.find("[value="+v1+"]").attr('selected', 'selected').trigger("change");
                            });

                        } else {
                            $el.find("[value="+o.value+"]").attr('selected', 'selected').trigger("change");
                        }

                    } else if ($el.data('value') !== undefined) {

                        if (o.value instanceof Array) {

                            $.each($el.data('value'), function(i1, v1){
                                if (v1) $el.find("[value="+v1+"]").attr('selected', 'selected').trigger("change");
                            });

                        } else {
                            $el.find("[value="+$el.data('value')+"]").attr('selected', 'selected').trigger("change");
                        }

                    } else {

                        $el.prepend('<option selected disabled value=""> '+o.emptyText+' </option>');

                    }

                    setTimeout(function(){$el.find('[selected]').prop('selected', true);},0);

                    if (typeof o.success === 'function') {
                        o.success($el, data);
                    }

                    if ($el.attr("multiple") === 'multiple') {

                        if (o.debug === true) console.log('multiple', 'multiple');
                        o.multiple = true;

                    }

                    if (o.multiple === true) {

                        $el.attr({
                            "multiple":"multiple",
                            "data-plugin":"select2",
                            "data-placeholder": o.emptyText
                        });
                        o.select2 = true;
                        if (o.debug === true) console.log('multiple', true);

                    }

                    if (o.select2 === true) {

                        if (o.debug === true) console.log('select2', true);
                        $el.find("option[value='']").remove();

                        $.components.init("select2");
                        if (o.debug === true) console.log('select2', 'init');

                    }

                };

                $.store({
                    method:o.method,
                    url:o.url,
                    cache:o.cache,
                    success:function(data){

                            successCombo(o, $el, data);

                            if (typeof o.success === 'function') {
                                    o.success($el, data);
                            }

                            $el.on("contextmenu", function(){

                              $el.find(":selected").prop('selected', false);
                              var $disabled = $el.find(":disabled");
                              $disabled.prop({
                                'disabled':false,
                                'selected':true
                              });
                              $disabled.prop('disabled', true);                              

                            });

                            $el.on("dblclick", function(){

                                $el.html('<option desabled selected>Atualizando...</option>');

                                $.store({
                                    method:o.method,
                                    url:o.url,
                                    cache:false,
                                    success:function(data){

                                        successCombo(o, $el, data);

                                        if (typeof o.success === 'function') {
                                                o.success($el, data);
                                        }

                                    }
                                });

                            });

                    }
                });

            });

        }
    });

})(jQuery);
