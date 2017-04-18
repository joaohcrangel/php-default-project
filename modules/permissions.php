<?php

$app->get('/permissions', function () {

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('despermission')) {
		array_push($where, "despermission LIKE '%".get('despermission')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AND ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_permissions
	".$where." LIMIT ?, ?;";

	$pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Admin\Permissions",
        $itemsPerPage
    );

    $permissions = $pagination->getPage($currentPage);

	echo success(array(
		"data"=>$permissions->getFields(),
		"currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post('/permissions', function () {

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$permission = new Hcode\Admin\Permission($_POST);

	$permission->save();

	echo success(array(
		'data'=>$permission->getFields()
	));
});

$app->post('/permissions/:idpermission', function ($idpermission) {
	
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$permission = new Hcode\Admin\Permission((int)$idpermission);

	$permission->set($_POST);

	$permission->save();

	echo success(array(
		'data'=>$permission->getFields()
	));

});

$app->delete('/permissions/:idpermission', function ($idpermission) {

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$permission = new Hcode\Admin\Permission((int)$idpermission);

	$permission->remove();

	echo success();

});

$app->get('/permissions/:idpermission', function ($idpermission) {

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);
	
	$permission = new Hcode\Admin\Permission((int)$idpermission);

	echo success(array(
		'data'=>$permission->getFields()
	));

});

?>