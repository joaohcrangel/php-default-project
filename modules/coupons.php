<?php

$app->get("/coupons/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Coupons::listAll()->getFields()));

});

$app->post("/coupons", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idcoupon") > 0){
		$coupon = new Hcode\Shop\Coupon((int)post("idcoupon"));
	}else{
		$coupon = new Hcode\Shop\Coupon();
	}

	$coupon->set();

	$coupon->save();

	echo success(array("data"=>$coupon->getFields()));

});

$app->delete("/cupons/:idcoupon", function($idcoupon){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idcoupon){
		throw new Exception("Cupom não informado", 400);		
	}

	$coupon = new Hcode\Shop\Coupon((int)$idcoupon);

	if(!(int)$coupon->getidcoupon() > 0){
		throw new Exception("coupon não encontrado", 404);		
	}

	$coupon->remove();

	echo success();

});
//////////////////////////////////////////////////

// cupons tipos
$app->get("/coupons/types", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('descoupontype')) {
		array_push($where, "descoupontype LIKE '%".get('descoupontype')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_couponstypes
	".$where." limit ?, ?;";

	$pagination = new Hcode\Pagination(
        $query,
        array(),
        "CouponsTypes",
        $itemsPerPage
    );

     $couponstypes = $pagination->getPage($currentPage);


	echo success(array(
		"data"=>$couponstypes->getFields(),
		"currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));


});

$app->post("/coupons-types", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post('idcoupontype') > 0){
		$coupon = new Hcode\Shop\Coupon\Type((int)post('idcoupontype'));
	}else{
		$coupon = new Hcode\Shop\Coupon\Type();
	}

	$coupon->set($_POST);

	$coupon->save();

	echo success(array("data"=>$coupon->getFields()));

});

$app->delete("/coupons-types/:idcoupontype", function($idcoupontype){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!($idcoupontype)){
		throw new Exception("Tipo de cupom não informado", 400);		
	}

	$coupon = new Hcode\Shop\Coupon\Type((int)$idcoupontype);

	if(!(int)$coupon->getidcoupontype() > 0){
		throw new Exception("Tipo de cupom não encontrado", 404);		
	}

	$coupon->remove();

	echo success();

});

?>