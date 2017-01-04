<?php

class Usuario extends Model {

    public $required = array('idpessoa', 'desusuario', 'dessenha');
    protected $pk = "idusuario";

    const SESSION_NAME_LOCK = "USER.LOCK";
    const SESSION_INVALID_NAME = "Usuario-Login-Invalid";
    const LOGIN_INVALID_MAX = 3;
    const PASSWORD_HASH_COST = 12;

    public function get()
    {

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_usuarios_get(".$args[0].");");

    }

    public static function getByEmail($desemail):Usuario
    {
        
        $usuario = new Usuario();

        $usuario->queryToAttr("CALL sp_usuariosfromemail_get(?)", array(
            $desemail
        ));

        return $usuario;

    }

    public function save()
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_usuarios_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidusuario(),
                $this->getidpessoa(),
                $this->getdesusuario(),
                $this->getdessenha(),
                $this->getinbloqueado(),
                $this->getidusuariotipo()
            ));

            return $this->getidusuario();

        }else{

            return false;

        }

    }

    public function remove():boolean
    {

        $this->execute("CALL sp_usuarios_remove(".$this->getidusuario().")");

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

    public static function login($desusuario, $dessenha):Usuario
    {

      if (!$desusuario) {
        throw new Exception("Preencha o campo de login.", 400);
      }

      if (!$dessenha) {
        throw new Exception("Preencha a senha.", 400);
      }

        $sql = new Sql();

        $data = $sql->proc("sp_usuarioslogin_get", array(
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

    public function getPessoa():Pessoa
    {

        return $this->getObjectOrCreate('Pessoa', $this->getidpessoa());
    }

    public static function isLogged():bool
    {

        $usuario = Session::getUsuario();
        return ($usuario->getidusuario() > 0)?true:false;

    }

    public function hasPermissao(Permissao $permissao):bool
    {

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

    public function getPermissoes():Permissoes 
    {

        $permissoes = new Permissoes();

        $permissoes->loadFromQuery("
            SELECT * 
            FROM tb_permissoes a
            INNER JOIN tb_permissoesusuarios b ON a.idpermissao = b.idpermissao
            WHERE b.idusuario = ?
            ORDER BY a.despermissao;
        ", array(
            $this->getidusuario()
        ));

        return $permissoes;

    }

    public function getMenus():Menus 
    {

        $menus = new Menus();

        $menus->loadFromQuery("
            SELECT * 
            FROM tb_menus a
            INNER JOIN tb_permissoesmenus b ON a.idmenu = b.idmenu
            INNER JOIN tb_permissoesusuarios c ON b.idpermissao = c.idpermissao
            WHERE c.idusuario = ?
            ORDER BY a.nrordem;
        ", array(
            $this->getidusuario()
        ));

        return $menus;

    }

}

?>
