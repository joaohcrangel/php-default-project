<?php

class Usuarios extends Collection {

    protected $class = "Usuario";
    protected $saveQuery = "CALL sp_usuario_save(?, ?, ?, ?, ?);";
    protected $saveArgs = array("idusuario", "idpessoa", "desusuario", "dessenha", "inbloqueado");
    protected $pk = "idusuario";

    public function get(){}

    public static function listAll(){

    	$usuarios = new Usuarios();

    	$usuarios->loadFromQuery("CALL sp_usuarios_list()");

    	return $usuarios;

    }

    public static function listFromMenu(Menu $menu){

        $usuarios = new Usuarios();

        $usuarios->loadFRomQuery("CALL sp_usuariosfrommenus_list(?)", array(
            $menu->getidmenu()
        ));

        return $usuarios;

    }

}

?>