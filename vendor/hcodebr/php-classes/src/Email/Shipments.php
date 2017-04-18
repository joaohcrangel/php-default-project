<?php

namespace Hcode\Email;

use Hcode\Collection;

class Shipments extends Collection {

    protected $class = "Hcode\Email\Shipment";
    protected $saveQuery = "sp_emailsshipments_save";
    protected $saveArgs = array("idshipment", "idemail", "idcontact", "dtsent", "dtreceived", "dtvisualized", "dtregister");
    protected $pk = "idshipment";

    public function get(){}

}

?>