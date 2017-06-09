<?php

namespace Hcode\Site\Carousel;

use Hcode\Collection;
use Hcode\Site\Carousel;

class Items extends Collection {

    protected $class = "Hcode\Site\Carousel\Item";
    protected $saveQuery = "sp_carouselsitems_save";
    protected $saveArgs = array("iditem", "desitem", "descontent", "nrorder", "idtype", "idcover", "idcarousel");
    protected $pk = "iditem";

    public function get(){}

    public function getByHcode_Site_Carousel(Carousel $carousel):Items
    {

        $this->loadFromQuery("CALL sp_itemsfromcarousel_list(?);", array(
            $carousel->getidcarousel()
        ));

        return $this;

    }

}

?>