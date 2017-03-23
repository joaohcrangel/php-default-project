<?php

class Usuarios extends Collection {

    protected $class = "Usuario";
    protected $saveQuery = "CALL sp_usuario_save(?, ?, ?, ?, ?);";
    protected $saveArgs = array("idusuario", "idpessoa", "desusuario", "dessenha", "inbloqueado");
    protected $pk = "idusuario";

    public function get(){}

    public static function listAll($filters = array()){

        $where = array();
 
        if (isset($filters['despessoa']) && $filters['despessoa']) {
            array_push($where, "b.despessoa LIKE '%".$filters['despessoa']."%'");
        }

        if (isset($filters['desusuario']) && $filters['desusuario']) {
            array_push($where, "a.desusuario = '".$filters['desusuario']."'");
        }

        if (isset($filters['a.idusuariotipo']) && (int)$filters['idusuariotipo'] > 0) {
            array_push($where, "a.idusuariotipo = '".$filters['idusuariotipo']."'");
        }

        if (count($where) > 0) {
            $where = "WHERE ".implode(' AND ', $where);
        } else {
            $where = '';
        }

    	$usuarios = new Usuarios();

    	$usuarios->loadFromQuery("
            SELECT *
            FROM tb_usuarios a
            INNER JOIN tb_pessoasdados b ON a.idpessoa = b.idpessoa
            $where
            ORDER BY b.despessoa, a.desusuario
        ");

    	return $usuarios;

    }

    public static function listFromMenu(Menu $menu){

        $usuarios = new Usuarios();

        $usuarios->loadFromQuery("CALL sp_usuariosfrommenus_list(?)", array(
            $menu->getidmenu()
        ));

        return $usuarios;

    }

    public function getByPessoa(Pessoa $pessoa):Usuarios
    {

        $this->loadFromQuery("CALL sp_usuariosfrompessoa_list(?);", array(
            $pessoa->getidpessoa()
        ));

        return $this;

    }

}

?>