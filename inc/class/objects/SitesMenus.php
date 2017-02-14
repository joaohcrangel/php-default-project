

<?php

class SitesMenus extends Collection {

    protected $class = "SiteMenu";
    protected $saveQuery = "sp_sitesmenus_save";
    protected $saveArgs = array("idmenu", "idmenupai", "desmenu", "desicone", "deshref", "nrordem", "nrsubmenus");
    protected $pk = "idmenu";

    public function get(){}

}

?>