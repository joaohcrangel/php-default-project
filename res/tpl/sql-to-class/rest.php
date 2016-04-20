<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {post} /{$rest_name} Creste {$object}.
 * @apiGroup {$object}
 *
 * @apiSuccess {Object} data Dados salvos.
 */
$app->post('/{$rest_name}', function () {

	${$object_name} = new {$object}($_POST);

	${$object_name}->save();

	echo success(array(
		'data'=>${$object_name}->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {post} /{$rest_name}/:{$primarykey[0]} Edit {$object}.
 * @apiGroup {$object}
 *
 *
 * @apiParam {Number} {$primarykey[0]} Chave Primária.
 *
 * @apiSuccess {Object} data Dados salvos.
 */
$app->post('/{$rest_name}/:{$primarykey[0]}', function (${$primarykey[0]}) {

	if(!(int)${$primarykey[0]} > 0){
		http_response_code(400);
		throw new Exception("Informe o ID.");
	}
	
	${$object_name} = new {$object}((int)${$primarykey[0]});

	foreach ($_POST as $key => $value) {
		
		if(!in_array($key, array({$requireds}))){
			http_response_code(400);
			throw new Exception("O campo $key não existe.");
		}

		${$object_name}->{'set'.$key}($value);

	}

	${$object_name}->save();

	echo success(array(
		'data'=>${$object_name}->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {delete} /{$rest_name}/:{$primarykey[0]} Delete {$object}a.
 * @apiGroup {$object}
 *
 *
 * @apiParam {Number} {$primarykey[0]} Chave Primária.
 *
 */
$app->delete('/{$rest_name}/:{$primarykey[0]}', function (${$primarykey[0]}) {

	if(!(int)${$primarykey[0]} > 0){
		http_response_code(400);
		throw new Exception("Informe o ID.");
	}

	${$object_name} = new {$object}((int)${$primarykey[0]});

	${$object_name}->remove();

	echo json_encode(array(
		'success'=>true
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {get} /{$rest_name}/:{$primarykey[0]} Get {$object}a.
 * @apiGroup {$object}
 *
 *
 * @apiParam {Number} {$primarykey[0]} Chave Primária.
 *
 * @apiSuccess {Object} data Dados salvos.
 */
$app->get('/{$rest_name}/:{$primarykey[0]}', function (${$primarykey[0]}) {

	if(!(int)${$primarykey[0]} > 0){
		http_response_code(400);
		throw new Exception("Informe o ID.");
	}

	${$object_name} = new {$object}((int)${$primarykey[0]});

	echo json_encode(array(
		'success'=>true,
		'data'=>${$object_name}->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
?>