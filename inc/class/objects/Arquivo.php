<?php

class Arquivo extends Model {

    public $required = array('desdiretorio', 'desarquivo', 'desextensao', 'desnome', 'desalias');
    protected $pk = "idarquivo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_arquivos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_arquivos_save(?, ?, ?, ?, ?, ?);", array(
                $this->getidarquivo(),
                $this->getdesdiretorio(),
                $this->getdesarquivo(),
                $this->getdesextensao(),
                $this->getdesnome(),
                $this->getdesalias()
            ));

            return $this->getidarquivo();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->proc("sp_arquivos_remove", array(
            $this->getidarquivo()
        ));

        return true;
        
    }

    public static function upload($name, $type, $tmp_name, $error, $size):Arquivo
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

        $configs = Session::getConfiguracoes();
        $mimes = $configs->getByName('UPLOAD_MIME_TYPE');
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $ext = array_search(
            $finfo->file($tmp_name),
            $mimes,
            true
        );

        if (!$ext) {
            throw new RuntimeException('Formato de arquivo não permitido.');
        }

        $desnome = uniqid();
        $desarquivo = $desnome.".".$ext;

        if (!is_dir(PATH.$uploadDir)) {
            mkdir(PATH.$uploadDir);
        }

        if (!move_uploaded_file($tmp_name, PATH.$uploadDir.$desarquivo)) {

            throw new RuntimeException("Não foi possível salvar o arquivo.");
            
        }

        $arquivo = new Arquivo(array(
            'desdiretorio'=>'',
            'desarquivo'=>$desarquivo,
            'desextensao'=>$ext,
            'desnome'=>$desnome,
            'desalias'=>$name
        ));

        $arquivo->save();

        return $arquivo;

    }

}

?>