<?php 

$app->get("/".DIR_ADMIN."/exemplos/upload", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'head_title'=>'Administração'
        )
    ));

    $page->setTpl('/admin/exemplos-upload');

});

$app->post("/".DIR_ADMIN."/exemplos/upload-form-exemplo-2", function(){
	
	$file = $_FILES['arquivo'];

	$arquivo = Hcode\FileSystem\File::upload(
		$file['name'],
		$file['type'],
		$file['tmp_name'],
		$file['error'],
		$file['size']
	);
	
	echo success(array(
		'data'=>$arquivo->getFields()
	));

});

$app->post("/".DIR_ADMIN."/exemplos/upload-form-exemplo-3", function(){

	$file = $_FILES['desarquivo'];

	$arquivo = Hcode\FileSystem\File::upload(
		$file['name'],
		$file['type'],
		$file['tmp_name'],
		$file['error'],
		$file['size']
	);
	
	echo success(array(
		'data'=>$arquivo->getFields()
	));

});

$app->post("/".DIR_ADMIN."/exemplos/upload-form-exemplo-4", function(){

	$arquivo = Hcode\FileSystem\File::download(post('desurl'));
	
	echo success(array(
		'data'=>$arquivo->getFields()
	));

});

?>