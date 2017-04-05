
<?php

class EmailsShipments extends Collection {

    protected $class = "EmailShipment";
    protected $saveQuery = "sp_emailsshipments_save";
    protected $saveArgs = array("idshipment", "idemail", "idcontact", "dtsent", "dtreceived", "dtvisualized", "dtregister");
    protected $pk = "idshipment";

    public function get(){}

}

?>