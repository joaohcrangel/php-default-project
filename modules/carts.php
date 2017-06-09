<?php

$app->get("/my-cart", function () {

    $cart = Hcode\Session::getCart();

    $products = $cart->getProducts();

    $data = $cart->getFields();

    $data["products"] = $products->getFields();

    echo success([
        "data"=>$data
    ]);

});

$app->get("/carts/all", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $where = array();

    if(isset($_GET['desperson']) && $_GET['desperson'] != ""){
        array_push($where, "b.desperson LIKE '%".utf8_decode(get('desperson'))."%'");
    }

    if(isset($_GET['dtstart']) && isset($_GET['dtend'])){
        if($_GET['dtstart'] != '' && $_GET['dtend'] != ''){
            array_push($where, "a.dtregister BETWEEN '".get('dtstart')."' AND '".get('dtend')."'");
        }
    }

    if(isset($_GET['idcart'])){
        if($_GET['idcart'] != '') array_push($where, "a.idcart = ".(int)get('idcart'));
    }

    if(count($where) > 0){
        $where = "WHERE ".implode(" AND ", $where);
    }else{
        $where = "";
    }

    $query = "
        SELECT SQL_CALC_FOUND_ROWS a.*, b.desperson FROM tb_carts a
            INNER JOIN tb_persons b USING(idperson) ".$where."
        ORDER BY b.desperson LIMIT ?, ?;
    ";

    $pagina = (int)get('pagina');
    $itemsPerPage = (int)get('limite');

    $pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Shop\Carts",
        $itemsPerPage
    );

    $carts = $pagination->getPage($pagina);

    echo success(array(
        "data"=>$carts->getFields(),
        "total"=>$pagination->getTotal(),
        "currentPage"=>$pagina,
        "itemsPerPage"=>$itemsPerPage
    ));

});

$app->get("/carts/:idcart/products", function($idcart){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $cart = new Hcode\Shop\Cart((int)$idcart);

    echo success(array("data"=>$cart->getproducts()->getFields()));

});

$app->post("/carts", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if((int)post('idcart') > 0){
        $cart = new Hcode\Shop\Cart((int)post('idcart'));
    }else{
        $cart = new Hcode\Shop\Cart();
    }

    $cart->set($_POST);

    $cart->save();

    echo success(array("data"=>$cart->getFields()));

});

$app->delete("/carts/:idcart", function($idcart){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idcart){
        throw new Exception("Carrinho não informado", 400);        
    }

    $cart = new Hcode\Shop\Cart((int)$idcart);

    if(!(int)$cart->getidcart() > 0){
        throw new Exception("Carrinho não encontrado", 404);        
    }

    $cart->remove();

    echo success();

});
///////////////////////////////////////////////////////

// carts Coupons
$app->get("/carts-coupons/all", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    echo success(array("data"=>Hcode\Shop\Coupons::listAll()->getFields()));

});

$app->post("/carts-coupons", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(isset($_POST['idcart'], $_POST['idcoupon'])){

        $coupon = new Hcode\Shop\Coupon();

        $coupon->queryToAttr("CALL sp_cartscoupons_save(?, ?);", array(
            post('idcart'),
            post('idcoupon')
        ));

        echo success();

    }else{
        throw new Exception("Carrinho ou cupom não informado", 400);        
    }

});

$app->delete("/carts/:idcart/coupons/:idcoupon", function($idcart, $idcoupon){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idcart){
        throw new Exception("Carrinho não informado", 400);        
    }

    if(!(int)$idcoupon){
        throw new Exception("Cupom não informado", 400);        
    }

    $coupon = new Hcode\Shop\Coupon();

    $coupon->queryToAttr("CALL sp_cartscoupons_remove(?, ?);", array(
        (int)$idcart,
        (int)$idcoupon
    ));

});
////////////////////////////////////////////////

// carts fretes
$app->get("/carts-freights/all", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    echo success(array("data"=>Hcode\Shop\Cart\Freights::listAll()->getFields()));

});

$app->post("/carts-freights", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idcart') > 0){
        $freight = new Hcode\Shop\Cart\Freight((int)post('idcart'));
    }else{
        $freight = new Hcode\Shop\Cart\Freight();
    }

    $freight->set($_POST);

    $freight->save();

    echo success(array("data"=>$freight->getFields()));

});

$app->delete("/carts-fretes/:idcart", function($idcart){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idcart){
        throw new Exception("Carrinho não informado", 400);        
    }

    $freight = new Hcode\Shop\Cart\Freight((int)$idcart);

    if(!(int)$freight->getidcart() > 0){
        throw new Exception("Carrinho não encontrado", 404);        
    }

    $freight->remove();

    echo success();

});

?>