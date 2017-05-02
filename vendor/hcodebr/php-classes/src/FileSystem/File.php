<?php

namespace Hcode\FileSystem;

use \finfo;
use \RuntimeException;
use Hcode\Model;
use Hcode\Exception;
use Hcode\Session;

class File extends Model {

    public $required = array('desdirectory', 'desfile', 'desextension', 'desalias');
    protected $pk = "idfile";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_files_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_files_save(?, ?, ?, ?, ?);", array(
                $this->getidfile(),
                $this->getdesdirectory(),
                $this->getdesfile(),
                $this->getdesextension(),
                $this->getdesalias()
            ));

            $this->getdesurl();

            return $this->getidfile();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $configs = Session::getConfigurations();
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        if ($this->getdesdirectory()) {
            $uploadDir .= $this->getdesdirectory();
        }

        if (!(int)$this->getidfile() > 0) {
            throw new Exception("Informe o ID do arquivo.");
        }

        if ($this->getidfile() > 0 && (!$this->getdesfile() || !$this->getdesextension())) {
            $this->reload();
        }

        $filename = PATH.$uploadDir.$this->getdesfile().'.'.$this->getdesextension();

        $deleted = false;

        if (file_exists($filename)) {
            $deleted = unlink($filename);
        }

        if ($deleted) {

            $this->proc("sp_files_remove", array(
                $this->getidfile()
            ));

        }

        return $deleted;
        
    }

    public function getdesthumb($preview = true):string
    {

        if ($preview === true && in_array($this->getdesextension(), array('jpg','gif','png','svg'))) {
            return $this->setdesthumb($this->getdesurl());
        } elseif (file_exists(SITE_PATH . "res/img/filetypes/" . $this->getdesextension() . ".svg")) {
            return $this->setdesthumb(SITE_PATH . "/res/img/filetypes/" . $this->getdesextension() . ".svg");
        } else {
            return $this->setdesthumb(SITE_PATH . "/res/img/filetypes/_.svg");
        }

    }

    public function getdesurl():string
    {

        $configs = Session::getConfigurations();
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        if ($this->getdesdirectory()) {
            $uploadDir = $this->getdesdirectory();
        }

        return $this->setdesurl(SITE_PATH.$uploadDir.$this->getdesfile().'.'.$this->getdesextension());

    }

    public static function upload($name, $type, $tmp_name, $error, $size, $subdir = ''):File
    {

        switch ($error) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('Nenhum arquivo foi enviado.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('O arquivo excedeu o tamanho máximo.');
            default:
                throw new RuntimeException('Erro desconhecido.');
        }

        if ($size > parse_size(ini_get('upload_max_filesize'))) {
            throw new RuntimeException('O arquivo excedeu o tamanho máximo de '.ini_get('upload_max_filesize').'.');
        }

        $configs = Session::getConfigurations();
        $mimes = $configs->getByName('UPLOAD_MIME_TYPE');
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $ext = array_search(
            $finfo->file($tmp_name),
            $mimes,
            true
        );

        if (!$ext) {
            throw new RuntimeException('Formato de arquivo não permitido. ('.$finfo->file($tmp_name).')');
        }

        $desname = uniqid();
        $desfile = $desname.".".$ext;

        if ($subdir) {
            $uploadDir .= $subdir.'/';
        }

        if (!is_dir(PATH.$uploadDir)) {
            mkdir(PATH.$uploadDir);
        }

        if (!move_uploaded_file($tmp_name, PATH.$uploadDir.$desfile)) {

            throw new RuntimeException("Não foi possível salvar o arquivo.");
            
        }

        $file = new File(array(
            'desdirectory'=>$uploadDir,
            'desfile'=>$desname,
            'desextension'=>$ext,
            'desalias'=>$name
        ));

        $file->save();

        return $file;

    }

    public static function download($link, $subdir = ''):File
    {

        $parseLink = parse_url($link);

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $content = curl_exec($ch);

        # get the content type
        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        $desname = uniqid();

        $configs = Session::getConfigurations();
        $mimes = $configs->getByName('UPLOAD_MIME_TYPE');
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        if ($subdir) {
            $uploadDir .= $subdir.'/';
        }

        if (!is_dir(PATH.$uploadDir)) {
            mkdir(PATH.$uploadDir);
        }

        if (!$content) {
            $content = file_get_contents($link);
        }

        $file = fopen(PATH.$uploadDir.$desname, 'w+');
        fwrite($file, $content);
        fclose($file);

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (!$mime) {
            $mime = $finfo->file(PATH.$uploadDir.$desname);
        }

        $ext = array_search(
            $mime,
            $mimes,
            true
        );

        if (!$ext) {
            throw new RuntimeException('Formato de arquivo não permitido.');
        }

        $desfile = $desname.".".$ext;

        rename(PATH.$uploadDir.$desname, PATH.$uploadDir.$desfile);

        $file = new File(array(
            'desdirectory'=>$subdir,
            'desfile'=>$desname,
            'desextension'=>$ext,
            'desalias'=>basename($parseLink['path']) ?? $desname
        ));

        $file->save();

        return $file;

    }

    public function getFields(){

        $this->getdesurl();
        $this->getdesthumb();

        return parent::getFields();

    }

}

?>