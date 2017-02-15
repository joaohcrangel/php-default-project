<?php

class Curso extends Model {

    public $required = array('idcurso', 'descurso', 'vlcargahoraria', 'nraulas', 'nrexercicios', 'inremovido');
    protected $pk = "idcurso";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_cursos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_cursos_save(?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcurso(),
                $this->getdescurso(),
                $this->getdestittulo(),
                $this->getvlcargahoraria(),
                $this->getnraulas(),
                $this->getnrexercicios(),
                $this->getdesdescricao(),
                $this->getinremovido()
            ));

            return $this->getidcurso();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_cursos_remove", array(
            $this->getidcurso()
        ));

        return true;
        
    }

    public function getSecoes():CursosSecoes
    {
        return new CursosSecoes($this);
    }

}

?>