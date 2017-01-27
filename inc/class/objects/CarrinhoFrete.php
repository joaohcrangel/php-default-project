<?php

class CarrinhoFrete extends Model {

    public $required = array('idcarrinho', 'descep', 'vlfrete');
    protected $pk = "idcarrinho";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_carrinhosfretes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_carrinhosfretes_save(?, ?, ?);", array(
                $this->getidcarrinho(),
                $this->getdescep(),
                $this->getvlfrete()
            ));

            return $this->getidcarrinho();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_carrinhosfretes_remove", array(
            $this->getidcarrinho()
        ));

        return true;
        
    }

}

?>