<?php

namespace Hcode\Site;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Sql;

class Url extends Model {

    public $required = array('desurl');
    protected $pk = "idurl";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_urls_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_urls_save(?, ?, ?);", array(
                $this->getidurl(),
                $this->getdesurl(),
                $this->getdestitle()
            ));

            return $this->getidurl();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_urls_remove", array(
            $this->getidurl()
        ));

        return true;
        
    }

    public static function checkUrl($desurl, $idurl){

        $sql = new Sql();

        if((int)$idurl > 0){

            $data = $sql->query("SELECT * FROM tb_urls WHERE desurl = ?;", array(
                $desurl
            ));

            if(count($data) > 0){
                $data2 = $sql->query("SELECT * FROM tb_urls WHERE desurl = ? AND idurl = ?;", array(
                    $desurl,
                    (int)$idurl
                ));

                if(!count($data2) > 0){
                    throw new Exception("Essa URL já existe", 400);                 
                }

                $url = new Url($data[0]);
            }            

        }else{

            $data = $sql->query("SELECT * FROM tb_urls WHERE desurl = ?", array(
                $desurl
            ));

            if(count($data) > 0){
                throw new Exception("A URL informada já existe", 400);          
            }

            $url = new Url(array(
                "desurl"=>$desurl
            ));

        }

        return $url;

    }

}

?>