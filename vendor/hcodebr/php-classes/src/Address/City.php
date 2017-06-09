<?php

namespace Hcode\Address;

use Hcode\Model;
use Hcode\Exception;

class City extends Model {

    public $required = array('idcity', 'descity', 'idstate');
    protected $pk = "idcity";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cities_get(".$args[0].");");
                
    }

    public static function loadFromName($name, $uf = ''){

        $city = new City();

        $params = array($name);
        $where = array('a.descity = ?');

        if ($uf) {
            array_push($where, 'b.desuf = ?');
            array_push($params, $uf);
        }

        $city->queryToAttr("
            SELECT * 
            FROM tb_cities a
            INNER JOIN tb_states b USING(idstate)
            INNER JOIN tb_countries c USING(idcountry)
            WHERE ".implode(' AND ', $where)."
            LIMIT 1
        ", $params);

        return $city;

    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cities_save(?, ?, ?);", array(
                $this->getidcity(),
                $this->getdescity(),
                $this->getidstate()
            ));

            return $this->getidcity();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_cities_remove", array(
            $this->getidcity()
        ));

        return true;
        
    }

}

?>