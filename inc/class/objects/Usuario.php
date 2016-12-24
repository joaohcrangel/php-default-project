<?php

class Usuario extends Model {

    public $required = array('idpessoa', 'desusuario', 'dessenha');
    protected $pk = "idusuario";

    const SESSION_NAME_LOCK = "USER.LOCK";
    const SESSION_NAME_REMEMBER = "LOGIN_REMEMBER";
    const SESSION_INVALID_NAME = "Usuario-Login-Invalid";
    const LOGIN_INVALID_MAX = 3;
    const PASSWORD_HASH_COST = 12;

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_usuario_get(".$args[0].");");

    }

    public static function getByEmail($desemail){
        
        $usuario = new Usuario();

        $usuario->queryToAttr("CALL sp_usuariofromemail_get(?)", array(
            $desemail
        ));

        return $usuario;

    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_usuario_save(?, ?, ?, ?, ?);", array(
                $this->getidusuario(),
                $this->getidpessoa(),
                $this->getdesusuario(),
                $this->getdessenha(),
                $this->getinbloqueado()
            ));

            return $this->getidusuario();

        }else{

            return false;

        }

    }

    public function remove(){

        $this->execute("CALL sp_usuario_remove(".$this->getidusuario().")");

        return true;

    }

    public static function getPasswordHash($dessenha){

        return password_hash($dessenha, PASSWORD_DEFAULT, array(
            'cost'=>Usuario::PASSWORD_HASH_COST
        ));

    }

    public function checkPassword($dessenha){

        if (!$this->getdessenha()) {
            throw new Exception("O hash da senha não foi carregado.", 404);
        }

        return password_verify($dessenha, $this->getdessenha());

    }

    public static function login($desusuario, $dessenha){

      if (!$desusuario) {
        throw new Exception("Preencha o campo de login.", 400);
      }

      if (!$dessenha) {
        throw new Exception("Preencha a senha.", 400);
      }

        $sql = new Sql();

        $data = $sql->proc("sp_usuariologin_get", array(
            $desusuario
        ));

        if (!isset($data[0]) || !(int)$data[0]['idusuario'] > 0) {
            throw new Exception("Usuário e/ou senha incorretos.", 403);
        }

        $usuario = new Usuario($data[0]);

        if (!$usuario->checkPassword($dessenha)) {
            throw new Exception("Usuário e/ou senha incorretos.", 403);
        }
        
        return $usuario;

    }

    public function getPessoa(){

        return $this->getObjectOrCreate('Pessoa', $this->getidpessoa());
    }

    public static function isLogged(){

        $usuario = Session::getUsuario();
        return ($usuario->getidusuario() > 0)?true:false;

    }

    public function hasPermissao(Permissao $permissao){

        $permissoes = $this->getPermissoes();

        if (!$permissoes) {
            $permissoes = $this->getdespermissoes();
        }

        switch(gettype($permissoes)) {
            case "string":
                $this->setPermissoes(explode(",", $permissoes));
                return $this->hasPermissao($permissao);
            break;
            case "array":
                $col = new Permissoes();
                foreach ($permissoes as $p) {
                    $col->add(new Permissao(array(
                        'idpermissao'=>(int)$p
                    )));
                }
                $this->setPermissoes($col);
                return $this->hasPermissao($permissao);
            break;
            case "object":
                $p = $permissoes->find("idpermissao", $permissao->getidpermissao());
                return ($p === false)?false:true;
            break;
            default:
                throw new Exception("Não foi possível verificar a permissão do usuário.", 400);                
            break;
        }

    }

}

?>
