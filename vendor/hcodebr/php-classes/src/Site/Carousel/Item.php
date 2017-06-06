<?php

namespace Hcode\Site\Carousel;

use Hcode\Model;
use Hcode\Exception;
use Hcode\FileSystem\File;

class Item extends Model {

    public $required = array('desitem', 'nrorder', 'idtype', 'idcarousel');
    protected $pk = "iditem";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carouselsitems_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carouselsitems_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getiditem(),
                $this->getdesitem(),
                $this->getdescontent(),
                $this->getnrorder(),
                $this->getidtype(),
                $this->getidcover(),
                $this->getidcarousel()
            ));

            return $this->getiditem();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_carouselsitems_remove", array(
            $this->getiditem()
        ));

        return true;
        
    }

    public function setCover(File $file){

        $this->setidcover($file->getidfile());

        $this->save();

    }

}

?>