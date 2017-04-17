<?php

namespace Hcode\Site\Carousel;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Site\Carousel\Items;

class Carousel extends Model {

    public $required = array('idcarousel', 'descarousel', 'inloop', 'innav', 'incenter', 'inautowidth', 'invideo', 'inlazyload', 'indots', 'nritems', 'nrstagepadding');
    protected $pk = "idcarousel";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carousels_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carousels_save(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcarousel(),
                $this->getdescarousel(),
                $this->getinloop(),
                $this->getinnav(),
                $this->getincenter(),
                $this->getinautowidth(),
                $this->getinvideo(),
                $this->getinlazyload(),
                $this->getindots(),
                $this->getnritems(),
                $this->getnrstagepadding()
            ));

            return $this->getidcarousel();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_carousels_remove", array(
            $this->getidcarousel()
        ));

        return true;
        
    }

    public function getItems():Items
    {
        return new Items($this);
    }

}

?>