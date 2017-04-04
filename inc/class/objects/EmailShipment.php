
<?php

class EmailShipment extends Model {

    public $required = array('idemail', 'idcontact');
    protected $pk = "idshipment";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_emailsshipments_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_emailsshipments_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidshipment(),
                $this->getidemail(),
                $this->getidcontact(),
                $this->getdtsent(),
                $this->getdtreceived(),
                $this->getdtvisualized(),
                $this->getdtregister()
            ));

            return $this->getidshipment();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_emailsshipments_remove", array(
            $this->getidshipment()
        ));

        return true;
        
    }

}

?>