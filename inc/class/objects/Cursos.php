<?php

class Cursos extends Collection {

    protected $class = "Curso";
    protected $saveQuery = "sp_cursos_save";
    protected $saveArgs = array("idcurso", "descurso", "destittulo", "vlcargahoraria", "nraulas", "nrexercicios", "desdescricao", "inremovido");
    protected $pk = "idcurso";

    public function get(){}

    public static function listAll():Cursos
    {

    	$cursos = new Cursos();

    	$cursos->loadFromQuery("CALL sp_cursos_list();");

    	return $cursos;

    }

}

?>