<?php
class Arquivo extends Model {

    public $required = array('desdiretorio', 'desarquivo', 'desextensao', 'desalias');
    protected $pk = "idarquivo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_arquivos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_arquivos_save(?, ?, ?, ?, ?);", array(
                $this->getidarquivo(),
                $this->getdesdiretorio(),
                $this->getdesarquivo(),
                $this->getdesextensao(),
                $this->getdesalias()
            ));

            $this->getdesurl();

            return $this->getidarquivo();

        }else{

            return false;

        }
        
    }

    public function remove():bool
    {

        $configs = Session::getConfiguracoes();
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        if ($this->getdesdiretorio()) {
            $uploadDir .= $this->getdesdiretorio();
        }

        if (!$this->getidarquivo() > 0) {
            throw new Exception("Informe o ID do arquivo.");
        }

        if ($this->getidarquivo() > 0 && (!$this->getdesarquivo() | !$this->getdesextensao())) {
            $this->reload();
        }

        $filename = PATH.$uploadDir.$this->getdesarquivo().'.'.$this->getdesextensao();

        $deleted = false;

        if (file_exists($filename)) {
            $deleted = unlink($filename);
        }

        if ($deleted) {

            $this->execute("sp_arquivos_remove", array(
                $this->getidarquivo()
            ));

        }

        return $deleted;
        
    }

    public function getdesthumb($preview = true):string
    {

        if ($preview === true && in_array($this->getdesextensao(), array('jpg','gif','png','svg'))) {
            return $this->setdesthumb($this->getdesurl());
        } elseif (file_exists(SITE_PATH . "res/img/filetypes/" . $this->getdesextensao() . ".svg")) {
            return $this->setdesthumb(SITE_PATH . "/res/img/filetypes/" . $this->getdesextensao() . ".svg");
        } else {
            return $this->setdesthumb(SITE_PATH . "/res/img/filetypes/_.svg");
        }

    }

    public function getdesurl():string
    {

        $configs = Session::getConfiguracoes();
        $uploadDir = $configs->getByName('UPLOAD_DIR');

        if ($this->getdesdiretorio()) {
            $uploadDir .= $this->getdesdiretorio();
        }

        return $this->setdesurl(SITE_PATH.$uploadDir.$this->getdesarquivo().'.'.$this->getdesextensao());

    }

    public static function upload($name, $type, $tmp_name, $error, $size, $subdir = ''):Arquivo
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
            throw new RuntimeException('Formato de arquivo não permitido. ('.$finfo->file($tmp_name).')');
        }

        $desnome = uniqid();
        $desarquivo = $desnome.".".$ext;

        if ($subdir) {
            $uploadDir .= $subdir.'/';
        }

        if (!is_dir(PATH.$uploadDir)) {
            mkdir(PATH.$uploadDir);
        }

        if (!move_uploaded_file($tmp_name, PATH.$uploadDir.$desarquivo)) {

            throw new RuntimeException("Não foi possível salvar o arquivo.");
            
        }

        $arquivo = new Arquivo(array(
            'desdiretorio'=>$subdir,
            'desarquivo'=>$desnome,
            'desextensao'=>$ext,
            'desalias'=>$name
        ));

        $arquivo->save();

        return $arquivo;

    }

    public static function download($link, $subdir = ''):Arquivo
    {

        $parseLink = parse_url($link);

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $content = curl_exec($ch);

        # get the content type
        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        $desnome = uniqid();

        $configs = Session::getConfiguracoes();
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

        $file = fopen(PATH.$uploadDir.$desnome, 'w+');
        fwrite($file, $content);
        fclose($file);

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (!$mime) {
            $mime = $finfo->file(PATH.$uploadDir.$desnome);
        }

        $ext = array_search(
            $mime,
            $mimes,
            true
        );

        if (!$ext) {
            throw new RuntimeException('Formato de arquivo não permitido.');
        }

        $desarquivo = $desnome.".".$ext;

        rename(PATH.$uploadDir.$desnome, PATH.$uploadDir.$desarquivo);

        $arquivo = new Arquivo(array(
            'desdiretorio'=>$subdir,
            'desarquivo'=>$desnome,
            'desextensao'=>$ext,
            'desalias'=>basename($parseLink['path']) ?? $desnome
        ));

        $arquivo->save();

        return $arquivo;

    }

    public function getFields(){

        $this->getdesurl();
        $this->getdesthumb();

        return parent::getFields();

    }

}

?>