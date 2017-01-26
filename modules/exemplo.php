<?php 

$app->get("/admin/exemplo",function(){

	$page = new AdminPage(array(
        'data'=>array(
            'head_title'=>'Administração'
        )
    ));

    $page->setTpl('/admin/exemplo');
});


 ?>