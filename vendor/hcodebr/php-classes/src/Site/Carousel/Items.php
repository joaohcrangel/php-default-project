<?php

namespace Hcode\Site\Carousel;

use Hcode\Collection;
use Hcode\Site\Carousel\Carousel;

class Items extends Collection {

    protected $class = "Hcode\Site\Carousel\Item";
    protected $saveQuery = "sp_carouselsitems_save";
    protected $saveArgs = array("iditem", "desitem", "descontent", "nrorder", "idtype", "idcarousel");
    protected $pk = "iditem";

    public function get(){}

    public function getByCarousel(Carousel $carousel):Items
    {

    	$this->loadFromQuery("CALL sp_itemsfromcarousel_list(?);", array(
    		$carousel->getidcarousel()
    	));

    	return $this;

    }

}

?>