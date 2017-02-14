<?php

$app->post('/{$rest_name}', function () {

	if((int)post('{$primarykey[0]}') > 0){
        ${$object_name} = new {$object}((int)post('{$primarykey[0]}'));
    }else{
        ${$object_name} = new {$object}();
    }

	${$object_name}->save();

	echo success(array(
		'data'=>${$object_name}->getFields()
	));

});

$app->post('/{$rest_name}/:{$primarykey[0]}', function (${$primarykey[0]}) {
	
	${$object_name} = new {$object}((int)${$primarykey[0]});

	${$object_name}->set($_POST);

	${$object_name}->save();

	echo success(array(
		'data'=>${$object_name}->getFields()
	));

});

$app->delete('/{$rest_name}/:{$primarykey[0]}', function (${$primarykey[0]}) {

	${$object_name} = new {$object}((int)${$primarykey[0]});

	${$object_name}->remove();

	echo success();

});

$app->get('/{$rest_name}/:{$primarykey[0]}', function (${$primarykey[0]}) {

	${$object_name} = new {$object}((int)${$primarykey[0]});

	echo success(array(
		'data'=>${$object_name}->getFields()
	));

});

?>