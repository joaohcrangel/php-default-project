<?php

class SiteMenu extends Model {

    public $required = array('desmenu', 'nrorder', 'desicon', 'deshref');
    protected $pk = "idmenu";

    const SESSION_NAME = "SITE_MENU";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_sitesmenus_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_sitesmenus_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidmenufather(),
                $this->getidmenu(),
                $this->getdesicon(),
                $this->getdeshref(),
                $this->getnrorder(),
                $this->getdesmenu()
            ));

            SiteMenu::updateFile();

            return $this->getidmenu();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_sitesmenus_remove", array(
            $this->getidmenu()
        ));

        SiteMenu::updateFile();

        return true;
        
    }

    public static function updateFile()
    {

        $file = fopen(PATH."/res/tpl/header-menu.html", "w+");
        fwrite($file, SiteMenu::getAllMenuHTML());
        fclose($file);

    }

    public static function getMenus(SiteMenu $menuPai, SitesMenus $menusTodos) {

        $roots = $menusTodos->filter('idmenufather', $menuPai->getidmenu());

        $subs = new SitesMenus();

        foreach ($roots->getItens() as $menu) {

            if ($menu->getnrsubmenus() > 0) {
                $menu->setMenus(SiteMenu::getMenus($menu, $menusTodos));
            }

            $subs->add($menu);

        }

        return $subs;

    }

    public static function getAllMenus(){
        $root = new SiteMenu(array('idmenu' => 0));
        $menus = SitesMenus::listAll();
        return SiteMenu::getMenus($root, $menus);
    }

    public static function getMenuHTML(SiteMenu $menuPai, SitesMenus $menusTodos) {

        $roots = $menusTodos->filter('idmenufather', $menuPai->getidmenu());

        $html = '';

        if ($roots->getSize() > 0) {

            $html = '<ul>';

            foreach ($roots->getItens() as $menu) {

                $href = ($menu->getdeshref())?$menu->getdeshref():'javascript:void(0)';

                $html .= '
                    <li>
                        <a title="'.$menu->getdesmenu().'" href="'.$href.'">
                            <div>'.$menu->getdesmenu().'</div>
                        </a>
                        '.SiteMenu::getMenuHTML($menu, $menusTodos).'
                    </li>
                ';

                unset($menu);

            }

            $html .= '</ul>';

        }

        return $html;

    }

    public static function getMenuOL(SiteMenu $menuPai, SitesMenus $menusTodos) {

        $roots = $menusTodos->filter('idmenufather', $menuPai->getidmenu());

        $html = '';
        
        if ($roots->getSize() > 0) {

            $html = '<ol class="dd-list">';

            foreach ($roots->getItens() as $menu) {

                $html .= '
                    <li data-idmenu="'.$menu->getidmenu().'" data-desmenu="'.$menu->getdesmenu().'" class="dd-item dd-item-alt">
                        <div class="dd-handle"></div>
                        <div class="dd-content"><span><i class="icon '.$menu->getdesicone().'"></i> '.$menu->getdesmenu().' </span>
                            <button type="button" class="btn btn-icon btn-pure btn-xs waves-effect pull-xs-right btn-add"><i class="icon md-plus" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-icon btn-pure btn-xs waves-effect pull-xs-right btn-edit"><i class="icon md-edit" aria-hidden="true"></i></button>
                        </div>
                        '.SiteMenu::getMenuOL($menu, $menusTodos).'
                    </li>
                ';

                unset($menu);

            }

            $html .= '</ol>';

        }

        return $html;

    }

    public static function getAllMenuHTML(){
        $root = new SiteMenu(array('idmenu' => 0));
        $menus = SitesMenus::listAll();
        return SiteMenu::getMenuHTML($root, $menus);
    }

    public static function getAllMenuOL(){
        $root = new SiteMenu(array('idmenu' => 0));
        $menus = SitesMenus::listAll();
        return SiteMenu::getMenuOL($root, $menus);
    }

    public static function getMenuSession(){
        if (!isset($_SESSION[SiteMenu::SESSION_NAME])) {
            $_SESSION[SiteMenu::SESSION_NAME] = SiteMenu::getAllMenuHTML();
        }
        return $_SESSION[SiteMenu::SESSION_NAME];
    }

    public static function resetMenuSession(){
        if (isset($_SESSION[SiteMenu::SESSION_NAME])) unset($_SESSION[SiteMenu::SESSION_NAME]);
        SiteMenu::getMenuSession();
    }

}

?>