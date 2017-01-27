<?php 

$app->get("/admin/exemplo1",function(){

	$page = new AdminPage(array(
        'data'=>array(
            'head_title'=>'Administração'
        )
    ));

    $page->setTpl('/admin/exemplo1');
});


 ?>