<?php

namespace Hcode\Shop;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Shop\Carts;
use Hcode\Shop\Products;
use Hcode\Shop\Product\Prices;
use Hcode\Financial\Order\Orders;
use Hcode\FileSystem\File;
use Hcode\FileSystem\Files;
use Hcode\Site\Url;
use Hcode\Course\Course;

class Product extends Model {

    public $required = array('idproducttype', 'desproduct');
    protected $pk = "idproduct";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_products_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_products_save(?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidproduct(),
                $this->getidproducttype(),
                $this->getdesproduct(),
                $this->getinremoved(),
                $this->getvlprice(),
                $this->getidthumb(),
                $this->getdescode(),
                $this->getdesbarcode()
            ));

            return $this->getidproduct();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_products_remove", array(
            $this->getidproduct()
        ));

        return true;
        
    }

    public function getCarts():Carts
    {

        $carts = new Carts();

        $carts->loadFromQuery("CALL sp_cartsfromproduct_list(?);", array(
            $this->getidproduct()
        ));

        return $carts;

    }

    public function getOrders():Orders
    {

        $pagamentos = new Orders();

        $pagamentos->loadFromQuery("CALL sp_pagamentosfromproduct_list(?);", array(
            $this->getidproduct()
        ));

        return $pagamentos;

    }

    public function getPrices():Prices
    {

        $prices = new Prices();

        $prices->loadFromQuery("CALL sp_pricesfromproduct_list(?);", array(
            $this->getidproduct()
        ));

        return $prices;

    }

    public function getFiles():Files
    {

        $files = new Files();

        $files->loadFromQuery("
            SELECT * 
            FROM tb_files a
            INNER JOIN tb_productsfiles b ON a.idfile = b.idfile
            WHERE b.idproduct = ?
        ", array(
            $this->getidproduct()
        ));

        return $files;

    }

    public function addFile(File $file):bool
    {

        $this->execute("
            INSERT INTO tb_productsfiles (idproduct, idfile)
            VALUES(?, ?);
        ", array(
            $this->getidproduct(),
            $file->getidfile()
        ));

        return true;

    }

    public function setUrl(Url $url):Product
    {

        $this->queryToAttr("CALL sp_productsurls_save(?, ?);", array(
            $this->getidproduct(),
            $url->getidurl()
        ));

        return $this;

    }

    public function setCourse(Course $course):Product
    {

        $this->queryToAttr("CALL sp_productscourses_save(?, ?);", array(
            $this->getidproduct(),
            $course->getidcourse()
        ));

        return $this;

    }



}

?>