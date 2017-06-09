<?php

class {$object} extends Model {

    public $required = array({$requireds});
    protected $pk = {if="count($primarykey) > 1"}array({$primarykeys}){else}"{$primarykey[0]}"{/if};

    public function get(){

        $args = func_get_args();
        {if="count($primarykey)==1"}
if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL {$sp_get}(".$args[0].");");
        {else}
        {loop="$primarykey"}
        if(!isset($args[{$counter}])) throw new Exception($->pk[{$counter}]." não informado");
        {/loop}
        $this->queryToAttr("CALL {$sp_get}(".$args[0].". ".$args[1].");");
        {/if}
        
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL {$sp_save}({$params});", array(
                {$fieldssave}
            ));

            return $this->get{$primarykey[0]}();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("{$sp_remove}", array(
            $this->get{$primarykey[0]}()
        ));

        return true;
        
    }

}

?>