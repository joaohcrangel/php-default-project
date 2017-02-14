<?php

class Lugar extends Model {

    public $required = array('idlugar', 'deslugar', 'idendereco', 'idlugartipo');
    protected $pk = "idlugar";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_lugares_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            var_dump($this->getFields());
            exit;

            $this->queryToAttr("CALL sp_lugares_save(?, ?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidlugar(),
                $this->getidlugarpai(),
                $this->getdeslugar(),
                $this->getidendereco(),
                $this->getidlugartipo(),
                $this->getdesconteudo(),
                $this->getnrviews(),
                $this->getvlreview()
            ));

            return $this->getidlugar();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_lugares_remove(".$this->getidlugar().")");

        return true;
        
    }

    public function setCoordenada(Coordenada $c):Coordenada
    {

        $c->save();

        $this->execute("CALL sp_lugarescoordenadas_add(?, ?);", array(
            $this->getidlugar(),
            $c->getidcoordenada()
        ));

        return $c;

    }

    public function getLugaresHorarios():LugaresHorarios
    {

        return new LugaresHorarios($this);

    }

    public function removeHorarios()
    {

        return $this->execute("CALL sp_lugareshorariosall_remove(?)", array(
            $this->getidlugar()
        ));

    }

    public function setHorarios(LugaresHorarios $horarios):LugaresHorarios
    {

        $this->removeHorarios();

        $itens = $horarios->getItens();

        $horariosTodos = Language::getWeekdays();

        foreach ($itens as &$item) {
            $item->setidlugar($this->getidlugar());
        }

        $faltaDias = array();

        foreach ($horariosTodos as $h) {

            $has = false;

            foreach ($itens as $horario) {

                if ($horario->getnrdia() == $h['nrweekday']) {
                    $has = true;
                }

            }

            if (!$has) {
                array_push($faltaDias, $h['nrweekday']);
            }

        }

        $horarios->setItens($itens);

        foreach ($faltaDias as $dia) {
            $horarios->add(new LugarHorario(array(
                'nrdia'=>$dia,
                'idlugar'=>$this->getidlugar()
            )));
        }

        $horarios->save();

        return $this->getLugaresHorarios();

    }

}

?>