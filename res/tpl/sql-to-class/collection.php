<?php

class {$collection} extends Collection {

    protected $class = "{$object}";
    protected $saveQuery = "{$sp_save}";
    protected $saveArgs = array({$saveArgs});
    protected $pk = {if="count($primarykey) > 1"}array({$primarykeys}){else}"{$primarykey[0]}"{/if};

    public function get(){}

}

?>