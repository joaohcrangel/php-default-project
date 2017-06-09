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

        if((int)$idurl){

            $data = $sql->query("SELECT * FROM tb_urls WHERE desurl = ?;", array(
                $desurl
            ));

            if(count($data) > 0){                

                $data2 = $sql->query("SELECT * FROM tb_urls WHERE desurl = ? AND idurl = ?;", array(
                    $desurl,
                    (int)$idurl
                ));

                if(!count($data2) > 0){
                    throw new Exception("Essa URL já existe");
                }

                $url = new Url((int)$idurl);

            }else{

                $url = new Url(array(
                    "idurl"=>(int)$idurl,
                    "desurl"=>$desurl
                ));
                
            }

        }else{

            $data = $sql->query("SELECT * FROM tb_urls WHERE desurl = ?;", array(
                $desurl
            ));

            if(count($data) > 0){
                throw new Exception("Essa URL já existe");                
            }

            $url = new Url(array(
                "desurl"=>$desurl
            ));

        }

        return $url;

    }

    public static function getLastUrl():string
    {

        return $_SERVER['HTTP_REFERER'];

    }

    public static function getCurrentUrl():string
    {

        return $_SERVER['REQUEST_URI'];
        
    }

}

?>