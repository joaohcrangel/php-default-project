<?php

class Permissao extends Model {

    public $required = array("despermissao");
    protected $pk = "idpermissao";

    const SUPER = 1;
    const ADMIN = 2;
    const CLIENT = 3;

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");
        
        $this->queryToAttr("CALL sp_permissoes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_permissoes_save(?, ?);", array(
                $this->getidpermissao(),
                $this->getdespermissao()
            ));

            return $this->getidpermissao();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_permissoes_remove(".$this->getidpermissao().")");

        return true;
        
    }

    public static function checkSession($idpermissao, $redirect = false){

        $usuario = Session::getUsuario();

        if (!$usuario->isLogged() || !$usuario->hasPermissao(new Permissao(array("idpermissao"=>(int)$idpermissao)))) {

            switch($idpermissao) {
                case Permissao::SUPER:
                case Permissao::ADMIN:
                $url = SITE_PATH."/admin/login";
                break;

                case UsuarioTipo::CLIENTE:
                $url = SITE_PATH."/login";
                break;
            }

            if ($redirect === false) {
                throw new Exception("Acesso negado.", 403);
            } else {
                header("Location: {$url}");    
            }
            
            exit;

        }

    }

}

?>