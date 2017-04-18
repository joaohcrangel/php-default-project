<?php

namespace Hcode\Site;

use Hcode\Model;
use Hcode\Site\Menus;

class Menu extends Model {

    public $required = array('desmenu', 'nrorder');
    protected $pk = "idmenu";

    const SESSION_NAME = "SITE_MENU";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_sitesmenus_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            if (!$this->getdeshref()) $this->setdeshref("#");

            $this->queryToAttr("CALL sp_sitesmenus_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidmenufather(),
                $this->getidmenu(),
                $this->getdesicon(),
                $this->getdeshref(),
                $this->getnrorder(),
                $this->getdesmenu()
            ));

            Menu::updateFile();

            return $this->getidmenu();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_sitesmenus_remove", array(
            $this->getidmenu()
        ));

        Menu::updateFile();

        return true;
        
    }

    public static function updateFile()
    {

        $file = fopen(PATH."/res/tpl/header-menu.html", "w+");
        fwrite($file, Menu::getAllMenuHTML());
        fclose($file);

    }

    public static function getMenus(Menu $menuPai, Menus $menusTodos) {

        $roots = $menusTodos->filter('idmenufather', $menuPai->getidmenu());

        $subs = new Menus();

        foreach ($roots->getItens() as $menu) {

            if ($menu->getnrsubmenus() > 0) {
                $menu->setMenus(Menu::getMenus($menu, $menusTodos));
            }

            $subs->add($menu);

        }

        return $subs;

    }

    public static function getAllMenus(){
        $root = new Menu(array('idmenu' => 0));
        $menus = Menus::listAll();
        return Menu::getMenus($root, $menus);
    }

    public static function getMenuHTML(Menu $menuPai, Menus $menusTodos) {

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
                        '.Menu::getMenuHTML($menu, $menusTodos).'
                    </li>
                ';

                unset($menu);

            }

            $html .= '</ul>';

        }

        return $html;

    }

    public static function getMenuOL(Menu $menuPai, Menus $menusTodos) {

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
                        '.Menu::getMenuOL($menu, $menusTodos).'
                    </li>
                ';

                unset($menu);

            }

            $html .= '</ol>';

        }

        return $html;

    }

    public static function getAllMenuHTML(){
        $root = new Menu(array('idmenu' => 0));
        $menus = Menus::listAll();
        return Menu::getMenuHTML($root, $menus);
    }

    public static function getAllMenuOL(){
        $root = new Menu(array('idmenu' => 0));
        $menus = Menus::listAll();
        return Menu::getMenuOL($root, $menus);
    }

    public static function getMenuSession(){
        if (!isset($_SESSION[Menu::SESSION_NAME])) {
            $_SESSION[Menu::SESSION_NAME] = Menu::getAllMenuHTML();
        }
        return $_SESSION[Menu::SESSION_NAME];
    }

    public static function resetMenuSession(){
        if (isset($_SESSION[Menu::SESSION_NAME])) unset($_SESSION[Menu::SESSION_NAME]);
        Menu::getMenuSession();
    }

}

?>