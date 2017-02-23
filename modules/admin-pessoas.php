<?php 

$app->get("/".DIR_ADMIN."/pessoas-criar", function(){

   Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
    	'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/pessoas-criar');

});

$app->get("/".DIR_ADMIN."/pessoas/:idpessoa", function($idpessoa){

    Permissao::checkSession(Permissao::ADMIN, true);

    $pessoa = new Pessoa((int)$idpessoa);

    $pessoa->getPhotoURL();

    $endereco = $pessoa->getEndereco();
    $endereco->setdesenderecoresumido($endereco->getToString(Endereco::SUMMARY));

    $cpf = $pessoa->getDocumento(DocumentoTipo::CPF);
    $cpf->getFormatted();

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/pessoas-panel-new',  array(
        'pessoa'=>$pessoa->getFields(),
        'endereco'=>$endereco->getFields(),
        'cpf'=>$cpf->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/pessoas", function(){

   Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl('/admin/pessoas');

});

?>