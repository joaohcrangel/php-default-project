<?php

class User extends Model {

    public $required = array('iduser', 'idperson', 'desuser', 'despassword', 'inblocked', 'idusertype');
    protected $pk = "iduser";

    const SESSION_NAME_LOCK = "USER.LOCK";
    const SESSION_INVALID_NAME = "Usuario-Login-Invalid";
    const LOGIN_INVALID_MAX = 3;
    const PASSWORD_HASH_COST = 12;

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_users_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_users_save(?, ?, ?, ?, ?, ?);", array(
                $this->getiduser(),
                $this->getidperson(),
                $this->getdesuser(),
                $this->getdespassword(),
                $this->getinblocked(),
                $this->getidusertype()
            ));

            return $this->getiduser();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->execute("sp_users_remove", array(
            $this->getiduser()
        ));

        return true;
        
    }

    public static function getPasswordHash($despassword){

        return password_hash($despassword, PASSWORD_DEFAULT, array(
            'cost'=>User::PASSWORD_HASH_COST
        ));

    }

    public function checkPassword($despassword){

        if (!$this->getdespassword()) {
            throw new Exception("O hash da senha não foi carregado.", 404);
        }

        return password_verify($despassword, $this->getdespassword());

    }

    public static function login($desuser, $despassword):User
    {

      if (!$desuser) {
        throw new Exception("Preencha o campo de login.", 400);
      }

      if (!$despassword) {
        throw new Exception("Preencha a senha.", 400);
      }

        $sql = new Sql();

        $data = $sql->query("CALL sp_userslogin_get(?)", array(
            $desuser
        ));

        if (!isset($data[0]) || !(int)$data[0]['iduser'] > 0) {
            throw new Exception("Usuário e/ou senha incorretos.", 403);
        }

        $user = new User($data[0]);

        if (!$user->checkPassword($despassword)) {
            throw new Exception("Usuário e/ou senha incorretos.", 403);
        }
        
        return $user;

    }

    public function getPerson():Person
    {

        return $this->getObjectOrCreate('Person', $this->getidperson());
        
    }

    public static function isLogged():bool
    {

        $user = Session::getUser();
        return ($user->getiduser() > 0)?true:false;

    }

    public function hasPermission(Permission $permission):bool
    {

        $permissions = $this->getPermissions();

        if (!$permissions) {
            $permissions = $this->getdespermissions();
        }

        switch(gettype($permissions)) {
            case "string":
                $this->setpermissions(explode(",", $permissions));
                return $this->hasPermission($permission);
            break;
            case "array":
                $col = new Permissions();
                foreach ($permissions as $p) {
                    $col->add(new Permission(array(
                        'idpermission'=>(int)$p
                    )));
                }
                $this->setpermissions($col);
                return $this->hasPermission($permission);
            break;
            case "object":
                $p = $permissions->find("idpermission", $permission->getidpermission());
                return ($p === false)?false:true;
            break;
            default:
                throw new Exception("Não foi possível verificar a permissão do usuário.", 400);                
            break;
        }

    }

    public function getPermissions():Permissions 
    {

        $permissions = new Permissions();

        $permissions->loadFromQuery("
            SELECT * 
            FROM tb_permissions a
            INNER JOIN tb_permissionsusers b ON a.idpermission = b.idpermission
            WHERE b.iduser = ?
            ORDER BY a.despermission;
        ", array(
            $this->getiduser()
        ));

        return $permissions;

    }

    public function addPermission(permission $permission):bool
    {
        
        $this->execute("INSERT INTO tb_permissionsusers (idpermission, iduser) VALUES(?, ?);", array(
            $permission->getidpermission(),
            $this->getiduser()
        ));

        return true;

    }

    public function removePermission(Permission $permission):bool
    {
        
        $this->execute("DELETE FROM tb_permissionsusers WHERE idpermission = ? AND iduser = ?;", array(
            $permission->getidpermission(),
            $this->getiduser()
        ));

        return true;

    }

    public function getMenus():Menus 
    {

        $menus = new Menus();

        $menus->loadFromQuery("
            SELECT * 
            FROM tb_menus a
            INNER JOIN tb_permissionsmenus b ON a.idmenu = b.idmenu
            INNER JOIN tb_permissionsusers c ON b.idpermission = c.idpermission
            WHERE c.iduser = ?
            ORDER BY a.nrordem;
        ", array(
            $this->getiduser()
        ));

        return $menus;

    }

}

?>