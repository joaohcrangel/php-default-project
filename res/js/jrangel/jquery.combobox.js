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
                select2:false,
                autoComplete:false,
                delay:250,
                minValue:1,
                queryName:'q',
                autoCompleteConfig:{
                    tplInput:
                    '<div class="jrangel-combobox-autocomplete">'+
                        '<input type="text" class="form-control">'+
                        '<span class="icon md-caret-down" style="position:absolute; right:14px; top:8px; font-size:20px;"></span>'+
                    '</div>',
                    tplResults:
                    '<div class="dropdown-menu" style="width: 100%; max-height:200px; overflow:auto;" role="menu"></div>',
                    tplResult:
                    '<a class="dropdown-item" href="javascript:void(0)" role="menuitem">{{display}}<strong class="pull-xs-right">{{rightText}}</strong></a>'
                }
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
                        //$.components.init("select2");
                        if (o.debug === true) console.log('select2', 'init');

                    }

                };

                if (o.autoComplete === true) {

                    if (o.debug === true) console.log('autoComplete true');

                    $el.wrap('<div class="jrangel-combobox" style="position:relative"></div>');

                    var $jRangelComBox = $el.closest('.jrangel-combobox');
                    var $inputContainer = $(o.autoCompleteConfig.tplInput);
                    var $input = $inputContainer.find('input');
                    var $icon = $inputContainer.find('span.icon');

                    var tplResult = Handlebars.compile(o.autoCompleteConfig.tplResult);
                    var tplResults = Handlebars.compile(o.autoCompleteConfig.tplResults);
                    var $results = $(tplResults());

                    function setLoading(bool){

                        console.log('setLoading', bool, $icon);

                        if (bool) {
                            $icon.removeClass('md-caret-down');
                            $icon.addClass('fa fa-refresh fa-spin');
                        } else {
                            $icon.removeClass('fa fa-refresh fa-spin');
                            $icon.addClass('md-caret-down');
                        }

                    }

                    function appendTimeout(){

                        if (o.debug === true) console.log('appendTimeout', o.delay);

                        if (window.jRangelComboBoxTimer) {
                            clearTimeout(window.jRangelComboBoxTimer);
                        }

                        window.jRangelComboBoxTimer = setTimeout(loadResults, o.delay);

                    }

                    function loadResults(callback){

                        if (o.debug === true) console.log('loadResults');

                        if ($input.val().length >= o.minValue) {

                            setLoading(true);

                            var data = {};
                            data[o.queryName] = $input.val();

                            $.store({
                                cache:false,
                                url:o.url,
                                method:o.method,
                                debug:o.debug,
                                data:data,
                                success:function(cities){

                                    setLoading(false);
                                    $results.html('');

                                    $.each(cities, function(index, row){

                                        var $item = $(tplResult({
                                            display:row[o.displayField],
                                            rightText:row[o.displayFieldRight]
                                        }));

                                        $item.on('click', function(){
                                            
                                            $input.val(row[o.displayField]);
                                            $results.hide();
                                            $el.html('<option selected="selected" value="'+row[o.valueField]+'">'+row[o.displayField]+'</option>');

                                        });

                                        $(document).bind('click', function(){
                                            $(document).unbind('click');
                                            $results.hide();
                                        })

                                        $results.append($item);

                                    });

                                    $results.css('display', 'block');

                                },
                                failure:function(e){
                                    setLoading(false);
                                    System.showError(e);
                                }
                            });

                        }

                    }

                    $el.hide();
                    $jRangelComBox.append($inputContainer);

                    $input.on('change', function(){
                        appendTimeout();
                    });
                    $input.on('keyup', function(){
                        appendTimeout();
                    });
                    $input.on('paste', function(){
                        appendTimeout();
                    });
                    $input.on('blur', function(){
                        appendTimeout();
                    });
                    
                    $jRangelComBox.append($results);

                    if (o.debug === true) console.log($jRangelComBox, $input);

                } else {

                    if (o.debug === true) console.log('autoComplete false');

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

                }

            });

        }
    });

})(jQuery);
