<?php

namespace Hcode;

class SiteMenu extends Model {

    public $required = array('desmenu', 'nrorder', 'desicon', 'deshref', 'nrsubmenus');
    protected $pk = "idmenu";

    const SESSION_NAME = "SITE_MENU";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_sitesmenus_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_sitesmenus_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidmenufather(),
                $this->getidmenu(),
                $this->getdesicon(),
                $this->getdeshref(),
                $this->getnrorder(),
                $this->getdesmenu()
            ));

            return $this->getidmenu();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("sp_sitesmenus_remove", array(
            $this->getidmenu()
        ));

        return true;
        
    }

    public static function getMenus(SiteMenu $menufather, SitesMenus $allMenus) {

        $roots = $allMenus->filter('idmenufather', $menufather->getidmenu());

        $subs = new SitesMenus();

        foreach ($roots->getItens() as $menu) {

            if ($menu->getnrsubmenus() > 0) {
                $menu->setMenus(SiteMenu::getMenus($menu, $allMenus));
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

    public static function getMenuHTML(SiteMenu $menufather, SitesMenus $allMenus) {

        $roots = $allMenus->filter('idmenufather', $menufather->getidmenu());

        $html = '';

        if ($roots->getSize() > 0) {

            $html = '<ul class="'.(($menufather->getidmenu() === 0)?'site-menu':'site-menu-sub').'" '.(($menufather->getidmenu() === 0)?'data-plugin="menu"':'').'>';

            foreach ($roots->getItens() as $menu) {

                $href = ($menu->getdeshref())?'/'.DIR_ADMIN.$menu->getdeshref():'javascript:void(0)';

                $html .= '
                    <li data-idmenu="'.$menu->getidmenu().'" class="site-menu-item '.(($menu->getnrsubmenus() > 0)?'has-sub':'').'">
                        <a '.(($menu->getdeshref() !== '')?'class="animsition-link"':'').' title="'.$menu->getdesmenu().'" href="'.$href.'" data-slug="layout">
                            <i class="site-menu-icon '.$menu->getdesicon().'" aria-hidden="true"></i>
                            <span class="site-menu-title">'.$menu->getdesmenu().'</span>
                            '.(($menu->getnrsubmenus() > 0)?'<span class="site-menu-arrow"></span>':'').'
                        </a>
                        '.SiteMenu::getMenuHTML($menu, $allMenus).'
                    </li>
                ';

                unset($menu);

            }

            $html .= '</ul>';

        }

        return $html;

    }

    public static function getMenuOL(SiteMenu $menufather, SitesMenus $allMenus) {

        $roots = $allMenus->filter('idmenufather', $menufather->getidmenu());

        $html = '';
        
        if ($roots->getSize() > 0) {

            $html = '<ol class="dd-list">';

            foreach ($roots->getItens() as $menu) {

                $html .= '
                    <li data-idmenu="'.$menu->getidmenu().'" data-desmenu="'.$menu->getdesmenu().'" class="dd-item dd-item-alt">
                        <div class="dd-handle"></div>
                        <div class="dd-content"><span><i class="icon '.$menu->getdesicon().'"></i> '.$menu->getdesmenu().' </span>
                            <button type="button" class="btn btn-icon btn-pure btn-xs waves-effect pull-xs-right btn-add"><i class="icon md-plus" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-icon btn-pure btn-xs waves-effect pull-xs-right btn-edit"><i class="icon md-edit" aria-hidden="true"></i></button>
                        </div>
                        '.SiteMenu::getMenuOL($menu, $allMenus).'
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