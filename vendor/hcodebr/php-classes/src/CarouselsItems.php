<?php

namespace Hcode;

class CarouselsItems extends Collection {

    protected $class = "Hcode\CarouselItem";
    protected $saveQuery = "sp_carouselsitems_save";
    protected $saveArgs = array("iditem", "desitem", "descontent", "nrorder", "idtype", "idcarousel");
    protected $pk = "iditem";

    public function get(){}

    public function getByCarousel(Carousel $carousel):CarouselsItems
    {

    	$this->loadFromQuery("CALL sp_itemsfromcarousel_list(?);", array(
    		$carousel->getidcarousel()
    	));

    	return $this;

    }

}

?>