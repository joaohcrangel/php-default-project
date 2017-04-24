<?php

namespace Hcode\FileSystem;

use Hcode\Collection;
use Hcode\Place\PLace;
use Hcode\FileSystem\File;

class Files extends Collection {

    protected $class = "Hcode\FileSystem\File";
    protected $saveQuery = "sp_files_save";
    protected $saveArgs = array("idfile", "desdirectory", "desfile", "desextension", "desname");
    protected $pk = "idfile";

    public function get(){}

    public static function listAll():Files
    {

    	$file = new Files();

    	$file->loadFromQuery("select * from tb_files");

    	return $file;

    }

    public static function upload($_FILE):Files
    {

        $filesPost = array();

            if (isset($_FILE['name'])) {

            if (gettype($_FILE['name']) === 'array') {
                for ($i=0; $i < count($_FILE['name']); $i++) { 
                    array_push($filesPost, array(
                        'name'=>$_FILE['name'][$i],
                        'type'=>$_FILE['type'][$i],
                        'tmp_name'=>$_FILE['tmp_name'][$i],
                        'error'=>$_FILE['error'][$i],
                        'size'=>$_FILE['size'][$i]
                    ));
                }        
            } else {

                array_push($filesPost, array(
                    'name'=>$_FILE['name'],
                    'type'=>$_FILE['type'],
                    'tmp_name'=>$_FILE['tmp_name'],
                    'error'=>$_FILE['error'],
                    'size'=>$_FILE['size']
                ));
            }

        }

        $file = new Files();

        foreach ($filesPost as $f) {

            $file->add(File::upload(
                $f['name'],
                $f['type'],
                $f['tmp_name'],
                $f['error'],
                $f['size']
            ));

        }

        return $file;

    }

    public function getByPlace(Place $place):Files
    {

        $this->loadFromQuery("CALL sp_filesfromplace_list(?);", array(
            $place ->getidplace()
        ));

        return $this;

    }

}

?>