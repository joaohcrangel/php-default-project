<?php

namespace Hcode\Site;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Site\Carousel\Items;

class Carousel extends Model {

    public $required = array('descarousel', 'nrspeed', 'nrautoplay', 'desmode', 'inloop', 'nritems');
    protected $pk = "idcarousel";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carousels_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carousels_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcarousel(),
                $this->getdescarousel(),
                $this->getnrspeed(),
                $this->getnrautoplay(),
                $this->getdesmode(),
                $this->getinloop(),                
                $this->getnritems()
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

    public function getOptions():Carousel
    {

        $this->queryToAttr("SELECT nrspeed, nrautoplay, desmode, inloop FROM tb_carousels WHERE idcarousel = ?;", array(
            $this->getidcarousel()
        ));

        return $this;

    }

    public static function getHTML(int $idcarousel):array
    {

        $carousel = new Carousel($idcarousel);

        $html = '
            <section id="slider" class="slider-parallax swiper_wrapper full-screen clearfix">
                <div class="slider-parallax-inner">
        ';

        $items = $carousel->getItems()->getItens();

        if(count($items) > 0){

            $html .= '
                <div class="swiper-container swiper-parent">
                    <div class="swiper-wrapper">
            ';

            foreach ($items as $item) {

                // $url = "/res/img/hd/html5dev-fundo.bkp.jpg";
                
                $html .= '
                    <div class="swiper-slide dark" style="background-image: url('.$item->getdescover().');">
                        '.$item->getdescontent().'
                    </div>
                ';

            }

            $html .= '
                    </div>
                    <div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
                    <div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
                </div>
            ';

        }

        $html .= '
                
                <a href="#" data-scrollto="#content" data-offset="100" class="dark one-page-arrow">
                    <i class="icon-angle-down infinite animated fadeInDown"></i>
                </a>

                </div>
            </section>
        ';

        $columns = array("nrspeed", "nrautoplay", "desmode", "inloop");
        $options = [];

        foreach ($carousel->getFields() as $key => $field) {

            if(substr($key, 0, 2) == "in"){

                $bool = ($field == false) ? "false" : "true";

                $field = $bool;

            }
            
            foreach ($columns as $column) {
                
                if($key == $column){

                    $options[$column] = $field;

                }

            }

        }

        return array(
            "html"=>$html,
            "options"=>$options
        );

    }

}

?>