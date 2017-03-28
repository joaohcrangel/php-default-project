<?php

class MenuOld extends Model {

    public $required = array('nrordem', 'desmenu');
    protected $pk = "idmenu";
    
    const SESSION_NAME = "SYSTEM_MENU";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_menus_get(".$args[0].");");
                
    }

    public function save(){

        if ($this->getChanged() && $this->isValid()) {

            $this->queryToAttr("CALL sp_menus_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidmenupai(),
                $this->getidmenu(),
                $this->getdesicone(),
                $this->getdeshref(),
                $this->getnrordem(),
                $this->getdesmenu()
            ));

            return $this->getidmenu();

        } else {

            return false;

        }
        
    }

    public function remove() {

        $this->execute("CALL sp_menus_remove(".$this->getidmenu().")");
        return true;
        
    }

    public function addPermissoes(Permissoes $permissoes){

        $itens = $permissoes->getItens();

        foreach ($itens as &$permissao) {
            
            $permissao->queryToAttr("CALL sp_permissoesmenus_save(?, ?)", array(
                $permissao->getidpermissao(),
                $this->getidmenu()
            ));

        }

        $permissoes->setItens($itens);

        return $permissoes;

    }

    public function removePermissoes(Permissoes $permissoes){

        foreach ($permissoes->getItens() as $permissao) {
            
            $this->proc("sp_permissoesmenus_remove", array(
                $permissao->getidpermissao(),
                $this->getidmenu()
            ));

        }

        return true;

    }

    public static function getMenus(Menu $menuPai, Menus $menusTodos) {

        $roots = $menusTodos->filter('idmenupai', $menuPai->getidmenu());

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

        $roots = $menusTodos->filter('idmenupai', $menuPai->getidmenu());

        $html = '';

        if ($roots->getSize() > 0) {

            $html = '<ul class="'.(($menuPai->getidmenu() === 0)?'site-menu':'site-menu-sub').'" '.(($menuPai->getidmenu() === 0)?'data-plugin="menu"':'').'>';

            foreach ($roots->getItens() as $menu) {

                $href = ($menu->getdeshref())?'/'.DIR_ADMIN.$menu->getdeshref():'javascript:void(0)';

                $html .= '
                    <li data-idmenu="'.$menu->getidmenu().'" class="site-menu-item '.(($menu->getnrsubmenus() > 0)?'has-sub':'').'">
                        <a '.(($menu->getdeshref() !== '')?'class="animsition-link"':'').' title="'.$menu->getdesmenu().'" href="'.$href.'" data-slug="layout">
                            <i class="site-menu-icon '.$menu->getdesicone().'" aria-hidden="true"></i>
                            <span class="site-menu-title">'.$menu->getdesmenu().'</span>
                            '.(($menu->getnrsubmenus() > 0)?'<span class="site-menu-arrow"></span>':'').'
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

        $roots = $menusTodos->filter('idmenupai', $menuPai->getidmenu());

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