<?php

namespace Hcode;

class EmailsShipments extends Collection {

    protected $class = "Hcode\EmailShipment";
    protected $saveQuery = "sp_emailsshipments_save";
    protected $saveArgs = array("idshipment", "idemail", "idcontact", "dtsent", "dtreceived", "dtvisualized", "dtregister");
    protected $pk = "idshipment";

    public function get(){}

}

?>