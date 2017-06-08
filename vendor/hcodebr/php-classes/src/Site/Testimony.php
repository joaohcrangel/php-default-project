<?php

namespace Hcode\Site;

use Hcode\Model;
use Hcode\Exception;

class Testimony extends Model {

    public $required = array('idperson', 'dessubtitle', 'destestimony');
    protected $pk = "idtestimony";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_testimonial_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_testimonial_save(?, ?, ?, ?);", array(
                $this->getidtestimony(),
                $this->getidperson(),                
                $this->getdessubtitle(),
                $this->getdestestimony()
            ));

            return $this->getidtestimony();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_testimonial_remove", array(
            $this->getidtestimony()
        ));

        return true;
        
    }

}

?>