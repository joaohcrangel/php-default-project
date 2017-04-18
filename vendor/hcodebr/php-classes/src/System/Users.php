<?php

namespace Hcode\System;

use Hcode\Collection;
use Hcode\Admin\Menu;
use Hcode\Person\Person;

class Users extends Collection {

    protected $class = "Hcode\System\User";
    protected $saveQuery = "sp_users_save";
    protected $saveArgs = array("iduser", "idperson", "desuser", "despassword", "inblocked", "idusertype");
    protected $pk = "iduser";

    public function get(){}

    public static function listAll($filters = array()):Users
    {

        $where = array();
 
        if (isset($filters['desperson']) && $filters['desperson']) {
            array_push($where, "b.desperson LIKE '%".$filters['desperson']."%'");
        }

        if (isset($filters['desuser']) && $filters['desuser']) {
            array_push($where, "a.desuser = '".$filters['desuser']."'");
        }

        if (isset($filters['a.idusertype']) && (int)$filters['idusertype'] > 0) {
            array_push($where, "a.idusertype = '".$filters['idusertype']."'");
        }

        if (count($where) > 0) {
            $where = "WHERE ".implode(' AND ', $where);
        } else {
            $where = '';
        }

    	$users = new Users();

    	$users->loadFromQuery("
            SELECT *
            FROM tb_users a
            INNER JOIN tb_personsdata b ON a.idperson = b.idperson
            $where
            ORDER BY b.desperson, a.desuser
        ");

        $data = $users->getItens();

        foreach ($data as &$user) {
            $person = $user->getPerson()->getFields();
            $user->set($person);
        }

        $users->setItens($data);

    	return $users;

    }

    public static function listFromMenu(Menu $menu):Users
    {

        $users = new Users();

        $users->loadFromQuery("CALL sp_usersfrommenus_list(?)", array(
            $menu->getidmenu()
        ));

        return $users;

    }

    public function getByPerson(Person $person):Users
    {

        $this->loadFromQuery("CALL sp_usersfromperson_list(?);", array(
            $person->getidperson()
        ));

        return $this;

    }

}

?>