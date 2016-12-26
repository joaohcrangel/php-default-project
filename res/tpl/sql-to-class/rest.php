<?php

$app->post('/{$rest_name}', function () {

	${$object_name} = new {$object}($_POST);

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