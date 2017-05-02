<?php

namespace Hcode\Site;

use Hcode\Collection;

class Testimonial extends Collection {

    protected $class = "Hcode\Site\Testimony";
    protected $saveQuery = "sp_testimonial_save";
    protected $saveArgs = array("idtestimony","idperson", "dessubtitle", "destestimony");
    protected $pk = "idtestimony";

    public function get(){}

}

?>