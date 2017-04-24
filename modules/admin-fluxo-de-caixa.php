<?php 

$app->get("/".DIR_ADMIN."/fluxo-de-caixa", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-right'
            )
        )
    ));

    $page->setTpl("fluxo-de-caixa");

});

 ?>