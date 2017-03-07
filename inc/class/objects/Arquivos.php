<?php

class Arquivos extends Collection {

    protected $class = "Arquivo";
    protected $saveQuery = "sp_arquivos_save";
    protected $saveArgs = array("idarquivo", "desdiretorio", "desarquivo", "desextensao", "desnome");
    protected $pk = "idarquivo";

    public function get(){}

    public static function listAll():Arquivos
    {

    	$arquivo = new Arquivos();

    	$arquivo->loadFromQuery("select * from tb_arquivos");

    	return $arquivo;

    }

    public static function upload($_FILE):Arquivos
    {

        $files = array();

        if (gettype($_FILE['name']) === 'array') {
            for ($i=0; $i < count($_FILE['name']); $i++) { 
                array_push($files, array(
                    'name'=>$_FILE['name'][$i],
                    'type'=>$_FILE['type'][$i],
                    'tmp_name'=>$_FILE['tmp_name'][$i],
                    'error'=>$_FILE['error'][$i],
                    'size'=>$_FILE['size'][$i]
                ));
            }        
        } else {
            array_push($files, array(
                'name'=>$_FILE['name'],
                'type'=>$_FILE['type'],
                'tmp_name'=>$_FILE['tmp_name'],
                'error'=>$_FILE['error'],
                'size'=>$_FILE['size']
            ));
        }

        $arquivos = new Arquivos();

        foreach ($files as $f) {
            
            $arquivos->add(Arquivo::upload(
                $f['name'],
                $f['type'],
                $f['tmp_name'],
                $f['error'],
                $f['size']
            ));

        }

        return $arquivos;

    }

    public function getByLugar(Lugar $lugar):Arquivos
    {

        $this->loadFromQuery("CALL sp_arquivosfromlugar_list(?);", array(
            $lugar->getidlugar()
        ));

        return $this;

    }

}

?>